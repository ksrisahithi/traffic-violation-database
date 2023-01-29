function shiftFocus(ele,nextEle, vType) {
    let regExp;
    if(vType=='t') {
        regExp = /^[A-Za-z]+$/;
    } else regExp = /^\d+$/;
    if (!ele.value.match(regExp)) {
        let char = ele.value.charAt(ele.value.length - 1);
        ele.value = ele.value.slice(0,-1);
        if(ele.value.length == 2) {
            nextEle.value = char;
            nextEle.focus();
        }
        return;
    }
    if (ele.value.length > 2) {
        let nextVal = ele.value.charAt(2);
        ele.value = ele.value.substring(0,2);
        if(!nextVal.match(regExp)) nextEle.value = nextVal;
        nextEle.focus();
    }
}
state.addEventListener('input', () => {
    shiftFocus(state, no, 't');
})
no.addEventListener('input', () => {
    shiftFocus(no, somed, 'n');
})
somed.addEventListener('input', () => {
    shiftFocus(somed, no1, 't');
})
no1.addEventListener('input', () => {
    if(!no1.value.match(/^\d+$/)) {
        no1.value = no1.value.slice(0,-1);
        return;
    };
    if(no1.value.length>4) no1.value = no1.value.slice(0,-1);
})