class SetCalculator {
    tokenize(expr) {
        return expr.replace(/\s+/g, '')
            .match(/\[[^\[\]]*\]|[&|~^]|->/g)
            ?.filter(token => token.length > 0) || [];
    }

    isSetToken(token) { return /^\[.*\]$/.test(token); }

    parseSet(setStr) {
        if (!this.isSetToken(setStr)) {
            throw new Error(`Invalid set format: ${setStr}`);
        }
        const content = setStr.slice(1, -1).trim();
        if (content === '') return [];
        return content.split(',').map(item => {
            item = item.trim();
            if (/^-?\d+$/.test(item)) return parseInt(item, 10);
            if (/^['"].*['"]$/.test(item)) return item.slice(1, -1);
            return item;
        });
    }

    applyOperation(op, left, right) {
        // Преобразуем массивы в Set для операций
        const leftSet = new Set(left);
        const rightSet = new Set(right);

        switch (op) {
            case '&':
                // Пересечение: элементы, присутствующие в обоих множествах
                return [...leftSet].filter(x => rightSet.has(x));
            case '|':
                // Объединение: все уникальные элементы из обоих множеств
                return [...new Set([...left, ...right])];
            case '~':
                // Разность: элементы из left, отсутствующие в right
                return [...leftSet].filter(x => !rightSet.has(x));
            case '^':
                // Симметричная разность: (left - right) ∪ (right - left)
                const diff1 = [...leftSet].filter(x => !rightSet.has(x));
                const diff2 = [...rightSet].filter(x => !leftSet.has(x));
                return [...new Set([...diff1, ...diff2])];
            default:
                throw new Error(`Unknown operator: ${op}`);
        }
    }

    applyMappingChain(sets) {
        const length = sets[0].length;
        for (let i = 1; i < sets.length; i++) {
            if (sets[i].length !== length) {
                throw new Error(
                    `Mapping requires sets of equal length. ` +
                    `Set 0: ${length}, Set ${i}: ${sets[i].length}`
                );
            }
        }
        const result = [];
        for (let i = 0; i < length; i++) {
            const chain = sets.map(set => set[i]);
            result.push(chain.join(':'));
        }
        return result;
    }

    reverseMapping(setStr) {
        const parsed = this.parseSet(setStr);
        if (parsed.length === 0) {
            throw new Error('Cannot reverse mapping: empty set');
        }
        if (!parsed.every(item => typeof item === 'string')) {
            throw new Error('Cannot reverse mapping: all elements must be strings');
        }
        if (!parsed.every(item => item.includes(':'))) {
            throw new Error('Cannot reverse mapping: input must be a set of colon-separated strings');
        }

        const splitChains = parsed.map(item => item.split(':'));
        const numSets = splitChains[0].length;
        const length = splitChains.length;

        if (!splitChains.every(chain => chain.length === numSets)) {
            throw new Error('Inconsistent mapping chains: all elements must have the same number of parts');
        }

        // Группируем элементы по позициям в цепочке
        const grouped = Array.from({ length: numSets }, (_, setIndex) =>
            Array.from({ length }, (_, itemIndex) => splitChains[itemIndex][setIndex])
        );

        return grouped.map(set => {
            return `[${set.join(',')}]`;
        }).join('->');
    }

    evaluate(expr) {
        if (!expr || !expr.trim()) return '[]';
        const tokens = this.tokenize(expr);
        if (tokens.length === 0) return '[]';

        if (tokens.length === 1 && this.isSetToken(tokens[0])) {
            const parsedSet = this.parseSet(tokens[0]);
            if (parsedSet.length > 0 && parsedSet.every(item => typeof item === 'string' && item.includes(':'))) {
                try {
                    return this.reverseMapping(tokens[0]);
                } catch (error) {
                    console.warn('Reverse mapping failed, falling back to normal formatting:', error.message);
                    return this.formatSet(parsedSet);
                }
            } else {
                return this.formatSet(parsedSet);
            }
        }

        if (!this.isSetToken(tokens[0])) {
            throw new Error('Expression must start with a set');
        }

        let currentSets = [this.parseSet(tokens[0])];
        let pos = 1;

        while (pos < tokens.length) {
            const op = tokens[pos];
            pos++;

            if (!['&', '|', '~', '^', '->'].includes(op)) {
                throw new Error(`Invalid operator: ${op}`);
            }

            if (pos >= tokens.length || !this.isSetToken(tokens[pos])) {
                throw new Error('Expected set after operator');
            }

            const nextSet = this.parseSet(tokens[pos]);
            pos++;

            if (op === '->') {
                currentSets.push(nextSet);
            } else {
                const mapped = this.applyMappingChain(currentSets);
                const nextResult = this.applyOperation(op, mapped, nextSet);
                currentSets = [nextResult];
            }
        }

        if (currentSets.length > 1) {
            return this.formatSet(this.applyMappingChain(currentSets));
        }
        return this.formatSet(currentSets[0]);
    }

    formatSet(set) {
        if (Array.isArray(set)) {
            const hasMappingChains = set.length > 0 && set.every(item => typeof item === 'string' && item.includes(':'));
            if (hasMappingChains) {
                return `[${set.join(',')}]`;
            } else {
                // Сортировка: числа по возрастанию, строки — лексикографически
                const sorted = [...set].sort((a, b) => {
                    if (typeof a === 'number' && typeof b === 'number') return a - b;
            if (typeof a === 'string' && typeof b === 'string') return a.localeCompare(b);
            // Если типы разные, преобразуем к строке
            return String(a).localeCompare(String(b));
        });
                return `[${sorted.join(',')}]`;
            }
        }
        // Для не-массивов (на всякий случай)
        return `[${String(set)}]`;
    }
}

const setCalculator = new SetCalculator();

class VectorExpressionProcessor {
    constructor() { this.vectors={}; this.nextVectorId=0; }
    process(input) {
        try {
            const expression=this._extractVectors(input);
            const resultVector=this._evaluateExpression(expression);
            return this._formatVector(resultVector);
        } catch (error) {
            throw new Error(`Ошибка обработки выражения: ${error.message}`);
        }
    }
    _extractVectors(input) {
        const vectorMatches=input.match(/\{[^}]+\}/g)||[];
        let expression=input;
        vectorMatches.forEach(vectorStr=>{
            const placeholder=this._createVectorPlaceholder();
            const vector=this._parseVector(vectorStr.slice(1,-1));
            this.vectors[placeholder]=vector;
            expression=expression.replace(vectorStr,placeholder);
        }); return expression;
    }
    _createVectorPlaceholder() {
        const placeholder=`VECTOR_${this.nextVectorId}`;
        this.nextVectorId++; return placeholder;
    }
    _parseVector(str) {
        return str.split(';').map(coord=>{
            try {
                return Number(Function('"use strict"; return ('+coord.trim()+')')());
            } catch (error) {
                throw new Error(`Ошибка в координате "${coord}": ${error.message}`);
            }
        });
    }
    _formatVector(vector) { return '{'+vector.join(';')+'}'; }
    _evaluateExpression(expr) {
        expr=expr.replace(/\s+/g,'');
        while (expr.includes('(')) {
            expr=expr.replace(/\([^()]+\)/g,match=>{
                const inner=match.slice(1,-1);
                return this._evaluateSimpleExpression(inner);
            });
        } return this._evaluateSimpleExpression(expr);
    }
    _evaluateSimpleExpression(expr) {
        const tokens=expr.match(/(VECTOR_\d+|\*\*|[+\-*/()]|\d+(?:\.\d+)?)/g)||[];
        const tokenValues=tokens.map(token=>{
            if (token.startsWith('VECTOR_')) {
                return this.vectors[token];
            } else if (!isNaN(token)) {
                return parseFloat(token);
            } else { return token; }
        }); for (let i=tokenValues.length-1; i>=0; i--) {
            if (tokenValues[i]==='**') {
                const left=tokenValues[i-1];
                const right=tokenValues[i+1];
                tokenValues.splice(i-1,3,this._applyOperation(left,right,'**'));
                i-=2;
            }
        } for (let i=0; i<tokenValues.length; i++) {
            if (['*','/'].includes(tokenValues[i])) {
                const op=tokenValues[i];
                const left=tokenValues[i-1];
                const right=tokenValues[i+1];
                tokenValues.splice(i-1,3,this._applyOperation(left,right,op));
                i--;
            }
        } for (let i=0; i<tokenValues.length; i++) {
            if (['+','-'].includes(tokenValues[i])) {
                const op=tokenValues[i];
                const left=tokenValues[i-1];
                const right=tokenValues[i+1];
                tokenValues.splice(i-1,3,this._applyOperation(left,right,op));
                i--;
            }
        } if (tokenValues.length!==1) {
            throw new Error('Некорректное выражение');
        } return tokenValues[0];
    }
    _applyOperation(left,right,operator) {
        if (Array.isArray(left)&&Array.isArray(right)) {
            if (left.length!==right.length) {
                throw new Error('Векторы должны иметь одинаковую размерность');
            } switch (operator) {
                case '+':
                    return left.map((val,i)=>val+right[i]);
                case '-':
                    return left.map((val,i)=>val-right[i]);
                case '*':
                    return left.map((val,i)=>val*right[i]);
                case '/':
                    return left.map((val,i)=>{
                        if (right[i]===0) throw new Error('Деление на ноль');
                        return val/right[i];
                    });
                case '**':
                    return left.map((val,i)=>Math.pow(val,right[i]));
                default:
                    throw new Error(`Неподдерживаемая операция: ${operator}`);
            }
        } else if (Array.isArray(left)&&!Array.isArray(right)) {
            switch (operator) {
                case '+':
                    return left.map(val=>val+right);
                case '-':
                    return left.map(val=>val-right);
                case '*':
                    return left.map(val=>val*right);
                case '/':
                    if (right===0) throw new Error('Деление на ноль');
                    return left.map(val=>val/right);
                case '**':
                    return left.map(val=>Math.pow(val,right));
                default:
                    throw new Error(`Неподдерживаемая операция: ${operator}`);
            }
        } else if (!Array.isArray(left)&&Array.isArray(right)) {
            switch (operator) {
                case '+':
                    return right.map(val=>left+val);
                case '-':
                    return right.map(val=>left-val);
                case '*':
                    return right.map(val=>left*val);
                case '/':
                    return right.map(val=>{
                        if (val===0) throw new Error('Деление на ноль');
                        return left / val;
                    });
                case '**':
                    return right.map(val=>Math.pow(left,val));
                default:
                    throw new Error(`Неподдерживаемая операция: ${operator}`);
            }
        } else {
            switch (operator) {
                case '+': return left+right;
                case '-': return left-right;
                case '*': return left*right;
                case '/':
                    if (right===0) throw new Error('Деление на ноль');
                    return left/right;
                case '**': return Math.pow(left,right);
                default:
                    throw new Error(`Неподдерживаемая операция: ${operator}`);
            }
        }
    }
} const vectorProcessor=new VectorExpressionProcessor();
class ChemicalEquationBalancer {
    constructor() { this.elements=new Set(); }
    parseFormula(formula) {
        const result={}; let i=0; while (i<formula.length) {
            if (formula[i]==='(') {
                const end=this.findClosingBracket(formula,i);
                const groupContent=formula.substring(i+1,end);
                let j=end+1; let groupCount=1;
                const countMatch=/^(\d+)/.exec(formula.substring(j));
                if (countMatch) {
                    groupCount=parseInt(countMatch[1],10);
                    j+=countMatch[1].length;
                } const groupElements=this.parseFormula(groupContent);
                for (const [element,count] of Object.entries(groupElements)) {
                    result[element]=(result[element]||0)+count*groupCount;
                    this.elements.add(element);
                } i=j;
            } else {
                const elementMatch=/([A-Z][a-z]?)(\d*)/.exec(formula.substring(i));
                if (!elementMatch) throw new Error(`Invalid formula at position ${i}: ${formula}`);
                const element=elementMatch[1];
                const count=elementMatch[2]?parseInt(elementMatch[2],10):1;
                result[element]=(result[element]||0)+count;
                this.elements.add(element); i+=elementMatch[0].length;
            }
        } return result;
    }
    findClosingBracket(formula,start) {
        let depth=1; for (let i=start+1; i<formula.length; i++) {
            if (formula[i]==='(') depth++;
            else if (formula[i]===')') depth--;
            if (depth===0) return i;
        } throw new Error('Brackets in formula are not balanced');
    }
    parseEquation(equation) {
        const cleanEquation=equation.replace(/\s+/g,'');
        const [reactantsStr,productsStr]=cleanEquation.split('->');
        if (!reactantsStr||!productsStr) throw new Error('Invalid equation format');
        return {
            reactants: this.parseTerms(reactantsStr),
            products: this.parseTerms(productsStr)
        };
    }
    parseTerms(termString) {
        return termString.split('+').map(part=>{
            const match=/^(\d+)([A-Za-z()\d]+)$/.exec(part);
            return match?{ coefficient: parseInt(match[1],10), formula: match[2] }:{ coefficient: 1, formula: part };
        });
    }
    gcd(a,b) { while (b!==0) [a,b]=[b,a%b]; return a; }
    lcm(a,b) { return (a*b)/this.gcd(a,b); }
    balance(equation) {
        try {
            this.elements.clear(); const {reactants,products}=this.parseEquation(equation);
            if (this.isBalanced(reactants,products,Array(reactants.length+products.length).fill(1))) {
                return equation.replace(/\s+/g,'');
            } const allElements=Array.from(this.elements);
            const matrix=[]; for (const element of allElements) {
                const row=[]; for (const r of reactants) {
                    const elements=this.parseFormula(r.formula);
                    row.push((elements[element]||0)*r.coefficient);
                } for (const p of products) {
                    const elements=this.parseFormula(p.formula);
                    row.push(-(elements[element]||0)*p.coefficient);
                } matrix.push(row);
            } let coefficients=this.solveSystem(matrix,reactants.length,products.length);
            const gcd=coefficients.reduce((acc,c)=>this.gcd(acc,Math.abs(c)));
            coefficients=coefficients.map(c=>c/gcd);
            const formatTerms=(terms,coeffs,offset)=>terms.map((t,i)=>{
                const totalCoeff=t.coefficient*coeffs[offset+i];
                return totalCoeff>1?`${totalCoeff}${t.formula}`:t.formula;
            }); const balancedReactants=formatTerms(reactants,coefficients,0);
            const balancedProducts=formatTerms(products,coefficients,reactants.length);
            return `${balancedReactants.join('+')}->${balancedProducts.join('+')}`;
        } catch (error) {
            return `Error: ${error.message}`;
        }
    }
    solveSystem(matrix,numReactants,numProducts) {
        const totalVars=matrix[0].length;
        const maxCoeff=20;
        const coeffs=Array(totalVars).fill(1);
        function nextCombination() {
            for (let i=totalVars-1; i>=0; i--) {
                coeffs[i]++; if (coeffs[i]<=maxCoeff) break;
                coeffs[i]=1; if (i===0) return false;
            } return true;
        } do {
            if (this.checkSolution(matrix,coeffs)) {
                return [...coeffs];
            }
        } while (nextCombination());
        return this.simplifiedSolve(matrix);
    }
    simplifiedSolve(matrix) {
        const n=matrix[0].length;
        const solution=Array(n).fill(1);
        if (n===3) {
            for (let c1=1; c1<=10; c1++) {
                for (let c2=1; c2<=10; c2++) {
                    for (let c3=1; c3<=10; c3++) {
                        if (this.checkSolution(matrix,[c1,c2,c3])) {
                            return [c1,c2,c3];
                        }
                    }
                }
            }
        } return solution;
    }
    checkSolution(matrix, coefficients) {
        for (const row of matrix) {
            let sum=0; for (let j=0; j<row.length; j++) {
                sum+=row[j]*coefficients[j];
            } if (sum!==0) return false;
        } return true;
    }
    isBalanced(reactants,products,coeffs) {
        const elementCounts={};
        for (let i=0; i<reactants.length; i++) {
            const elements=this.parseFormula(reactants[i].formula);
            for (const [element,count] of Object.entries(elements)) {
                elementCounts[element]=(elementCounts[element]||0)+count*reactants[i].coefficient*coeffs[i];
            }
        } for (let i=0; i<products.length; i++) {
            const elements=this.parseFormula(products[i].formula);
            for (const [element,count] of Object.entries(elements)) {
                elementCounts[element]=(elementCounts[element]||0)-count*products[i].coefficient*coeffs[reactants.length+i];
            }
        } return Object.values(elementCounts).every(count => count === 0);
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
            } else if (/\{.*?\}/gi.test(promptExec.value)) {
                row.insertCell().textContent=vectorProcessor.process(promptExec.value);
            } else if (/[A-Z]+/g.test(promptExec.value)) {
                row.insertCell().textContent=balancer.balance(promptExec.value);
            } else {
                row.insertCell().textContent=solveSystem(promptExec.value);
            }
        } catch (error) {
            row.insertCell().textContent=`${error.message}`;
        }
    }
}
