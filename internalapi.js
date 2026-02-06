class SetCalculator {
    tokenize(expr) {
        return expr.replace(/\s+/g,'').match(/\[[^\[\]]*\]|[&|~^]/g)?.filter(token=>token.length>0)||[];
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
            case '&': return _.intersection(left,right);
            case '|': return _.union(left,right);
            case '~': return _.difference(left,right);
            case '^':
                const diff1=_.difference(left,right);
                const diff2=_.difference(right,left);
                return _.union(diff1,diff2);
            default:
                throw new Error(`Unknown operator: ${op}`);
        }
    }
    evaluate(expr) {
        if (!expr||!expr.trim()) return '[]';
        const tokens=this.tokenize(expr);
        if (tokens.length===0) return '[]';
        if (tokens.length===1&&this.isSetToken(tokens[0])) {
            return this.formatSet(this.parseSet(tokens[0]));
        } if (!this.isSetToken(tokens[0])) {
            throw new Error('Expression must start with a set');
        } let result=this.parseSet(tokens[0]);
        let pos=1; while (pos<tokens.length) {
            const op=tokens[pos]; pos++;
            if (!['&','|','~','^'].includes(op)) {
                throw new Error(`Invalid operator: ${op}`);
            } if (pos>=tokens.length||!this.isSetToken(tokens[pos])) {
                throw new Error('Expected set after operator');
            } const nextSet=this.parseSet(tokens[pos]);
            result=this.applyOperation(op,result,nextSet);
            pos++;
        } return this.formatSet(result);
    } formatSet(set) {
        const sorted=_.sortBy(set,item=>{
            if (typeof item==='number') return item;
            if (typeof item==='string') return item.toLowerCase();
            return String(item).toLowerCase();
        });
        const formatted=sorted.map(item=>{
            if (typeof item==='string') return `"${item}"`;
            return String(item);
        }); return `[${formatted.join(',')}]`;
    }
} const setCalculator=new SetCalculator();
function populateCommandIO() {
    if (requestMode.value=='terminal') {
        const tableBody=document.getElementById('commandData');
        const row=tableBody.insertRow();
        row.insertCell().textContent=promptExec.value;
        try {
            if (/\[.*?\]/gi.test(promptExec.value)) {
                row.insertCell().textContent=setCalculator.evaluate(promptExec.value);
            } else {
                row.insertCell().textContent=solveSystem(promptExec.value);
            }
        } catch (error) {
            row.insertCell().textContent=`${error.message}`;
        }
    }
}
