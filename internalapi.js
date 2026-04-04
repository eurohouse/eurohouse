class SetCalculator {
    tokenize(expr) {
        return expr.replace(/\s+/g,'')
            .match(/\[[^\[\]]*\]|[&|~^]|->/g)
            ?.filter(token=>token.length>0)||[];
    }
    isSetToken(token) { return /^\[.*\]$/.test(token); }
    parseSet(setStr) {
        if (!this.isSetToken(setStr)) {
            throw new Error(`Invalid set format: ${setStr}`);
        } const content=setStr.slice(1,-1).trim();
        if (content==='') return [];
        return content.split(',').map(item=>{
            item=item.trim();
            if (/^-?\d+$/.test(item)) return parseInt(item,10);
            if (/^['"].*['"]$/.test(item)) return item.slice(1,-1);
            return item;
        });
    }
    applyOperation(op,left,right) {
        switch (op) {
            case '&':
                return _.intersection(left,right);
            case '|':
                return _.union(left,right);
            case '~':
                return _.difference(left,right);
            case '^':
                const diff1=_.difference(left,right);
                const diff2=_.difference(right,left);
                return _.union(diff1,diff2);
            default:
                throw new Error(`Unknown operator: ${op}`);
        }
    }
    applyMappingChain(sets) {
        const length=sets[0].length;
        for (let i=1; i<sets.length; i++) {
            if (sets[i].length!==length) {
                throw new Error(
                    `Mapping requires sets of equal length. ` +
                    `Set 0: ${length}, Set ${i}: ${sets[i].length}`
                );
            }
        } const result=[];
        for (let i=0; i<length; i++) {
            const chain=sets.map(set=>set[i]);
            result.push(chain.join(':'));
        } return result;
    }
    reverseMapping(setStr) {
        const parsed=this.parseSet(setStr);
        if (parsed.length===0) {
            throw new Error('Cannot reverse mapping: empty set');
        } if (!parsed.every(item=>typeof item==='string')) {
            throw new Error('Cannot reverse mapping: all elements must be strings');
        } if (!parsed.every(item=>item.includes(':'))) {
            throw new Error('Cannot reverse mapping: input must be a set of colon-separated strings');
        } const splitChains=parsed.map(item=>item.split(':'));
        const numSets=splitChains[0].length;
        const length=splitChains.length;
        if (!splitChains.every(chain=>chain.length===numSets)) {
            throw new Error('Inconsistent mapping chains: all elements must have the same number of parts');
        } const grouped=Array.from({ length: numSets },(_,setIndex)=>Array.from({ length: length },(_,itemIndex)=>splitChains[itemIndex][setIndex]));
        return grouped.map(set=>{
            return `[${set.join(',')}]`;
        }).join('->');
    }
    evaluate(expr) {
        if (!expr||!expr.trim()) return '[]';
        const tokens=this.tokenize(expr);
        if (tokens.length===0) return '[]';
        if (tokens.length===1&&this.isSetToken(tokens[0])) {
            const parsedSet=this.parseSet(tokens[0]);
            if (parsedSet.length>0&&parsedSet.every(item=>typeof item==='string'&&item.includes(':'))) {
                try {
                    return this.reverseMapping(tokens[0]);
                } catch (error) {
                    console.warn('Reverse mapping failed, falling back to normal formatting:', error.message);
                    return this.formatSet(parsedSet);
                }
            } else {
                return this.formatSet(parsedSet);
            }
        } if (!this.isSetToken(tokens[0])) {
            throw new Error('Expression must start with a set');
        } let currentSets=[this.parseSet(tokens[0])];
        let pos=1; while (pos<tokens.length) {
            const op=tokens[pos]; pos++;
            if (!['&','|','~','^','->'].includes(op)) {
                throw new Error(`Invalid operator: ${op}`);
            } if (pos>=tokens.length||!this.isSetToken(tokens[pos])) {
                throw new Error('Expected set after operator');
            } const nextSet=this.parseSet(tokens[pos]);
            pos++; if (op==='->') {
                currentSets.push(nextSet);
            } else {
                const mapped=this.applyMappingChain(currentSets);
                const nextResult=this.applyOperation(op,mapped,nextSet);
                currentSets=[nextResult];
            }
        } if (currentSets.length>1) {
            return this.formatSet(this.applyMappingChain(currentSets));
        } return this.formatSet(currentSets[0]);
    }
    formatSet(set) {
        if (Array.isArray(set)) {
            const hasMappingChains=set.length>0&&set.every(item=>typeof item==='string'&&item.includes(':'));
            if (hasMappingChains) {
                return `[${set.join(',')}]`;
            } else {
                const sorted=_.sortBy(set,item=>{
                    if (typeof item==='number') return item;
                    if (typeof item==='string') return item.toLowerCase();
                    return String(item).toLowerCase();
                }); const formatted=sorted.map(item=>{
                    if (typeof item==='string') return item;
                    return String(item);
                }); return `[${formatted.join(',')}]`;
            }
        } if (typeof set==='object'&&!Array.isArray(set)) {
            const entries = Object.entries(set).map(([key, value]) => {
                const formattedKey = typeof key === 'string' ? key : key;
                const formattedValue = typeof value === 'string' ? value : value;
                return `${formattedKey}:${formattedValue}`;
            });
            return `{${entries.join(',')}}`;
        }
        const sorted=_.sortBy(set,item=>{
            if (typeof item==='number') return item;
            if (typeof item==='string') return item.toLowerCase();
            return String(item).toLowerCase();
        });
        const formatted=sorted.map(item=>{
            if (typeof item==='string') return item;
            return String(item);
        }); return `[${formatted.join(',')}]`;
    }
} const setCalculator=new SetCalculator();
class ChemicalEquationBalancer {
    constructor() { this.elements=new Set(); }
    parseFormula(formula) {
        const result={}; let i=0;
        while (i<formula.length) {
            if (formula[i]==='(') {
                const end=this.findClosingBracket(formula,i);
                const groupContent=formula.substring(i+1,end);
                const groupCountMatch=/(\d+)$/.exec(formula.substring(end+1));
                const groupCount=groupCountMatch?parseInt(groupCountMatch[1]):1;
                const groupElements=this.parseFormula(groupContent);
                for (const [element,count] of Object.entries(groupElements)) {
                    result[element]=(result[element]||0)+count*groupCount;
                } i=end+1+(groupCountMatch?groupCountMatch[1].length:0);
            } else {
                const elementMatch=/([A-Z][a-z]?)(\d*)/.exec(formula.substring(i));
                if (!elementMatch) break;
                const element=elementMatch[1];
                const count=elementMatch[2]?parseInt(elementMatch[2]):1;
                result[element]=(result[element]||0)+count;
                this.elements.add(element);
                i+=elementMatch[0].length;
            }
        } return result;
    }
    findClosingBracket(formula,start) {
        let depth=1;
        for (let i=start+1; i<formula.length; i++) {
            if (formula[i]==='(') depth++;
            else if (formula[i]===')') depth--;
            if (depth===0) return i;
        } throw new Error('Brackets in formula are not balanced.');
    }
    parseEquation(equation) {
        const cleanEquation=equation.replace(/\s+/g,'');
        const [reactantsStr,productsStr]=cleanEquation.split('->');
        const reactants=this.parseTerms(reactantsStr);
        const products=this.parseTerms(productsStr);
        return {reactants,products};
    }
    parseTerms(termString) {
        const terms=[]; const parts=termString.split('+');
        for (const part of parts) {
            const match=/^(\d+)(.+)$/.exec(part);
            if (match) {
                terms.push({
                    coefficient: parseInt(match[1]),
                    formula: match[2]
                });
            } else {
                terms.push({
                    coefficient: 1,
                    formula: part
                });
            }
        } return terms;
    }
    isBalanced(reactants,products,coeffs) {
        const elementCounts={};
        for (let i=0; i<reactants.length; i++) {
            const formula=reactants[i].formula;
            const baseCoefficient=reactants[i].coefficient;
            const elements=this.parseFormula(formula);
            for (const [element,count] of Object.entries(elements)) {
                elementCounts[element]=(elementCounts[element]||0)+count*baseCoefficient*coeffs[i];
            }
        } for (let i=0; i<products.length; i++) {
            const formula=products[i].formula;
            const baseCoefficient=products[i].coefficient;
            const elements=this.parseFormula(formula);
            for (const [element,count] of Object.entries(elements)) {
                elementCounts[element]=(elementCounts[element]||0)-count*baseCoefficient*coeffs[reactants.length+i];
            }
        } return Object.values(elementCounts).every(count=>count===0);
    }
    balance(equation) {
        try {
            this.elements.clear();
            const {reactants,products}=this.parseEquation(equation);
            const totalTerms=reactants.length+products.length;
            const maxCoeff=10; const coeffs=Array(totalTerms).fill(1);
            const nextCombination=()=>{
                for (let i=totalTerms-1; i>=0; i--) {
                    if (coeffs[i]<maxCoeff) { coeffs[i]++; return true; }
                    coeffs[i]=1;
                } return false;
            }; do {
                if (this.isBalanced(reactants,products,coeffs)) {
                    const balancedReactants=reactants.map((r,i)=>{
                        const totalCoefficient=r.coefficient*coeffs[i];
                        return totalCoefficient>1?`${totalCoefficient}${r.formula}`:r.formula;
                    }); const balancedProducts=products.map((p,i)=>{
                        const totalCoefficient=p.coefficient*coeffs[reactants.length+i];
                        return totalCoefficient>1?`${totalCoefficient}${p.formula}`:p.formula;
                    }); return `${balancedReactants.join('+')}->${balancedProducts.join('+')}`;
                }
            } while (nextCombination());
            return `Cannot balance equation: ${equation.replace(/\s+/g,'')}`;
        } catch (error) {
            return `Error: ${error.message}`;
        }
    }
} const balancer=new ChemicalEquationBalancer();
function populateCommandIO() {
    if (requestMode.value==='terminal') {
        const tableBody=document.getElementById('commandData');
        const row=tableBody.insertRow();
        row.insertCell().textContent=promptExec.value;
        try {
            if (/\[.*?\]/gi.test(promptExec.value)) {
                row.insertCell().textContent=setCalculator.evaluate(promptExec.value);
            } else if (/\[.*?\]/gi.test(promptExec.value)) {
                row.insertCell().textContent=balancer.balance(promptExec.value);
            } else {
                row.insertCell().textContent=solveSystem(promptExec.value);
            }
        } catch (error) {
            row.insertCell().textContent=`${error.message}`;
        }
    }
}
