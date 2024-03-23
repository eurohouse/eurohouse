<script>
function omniEnter() {
    var mode = requestMode.value; var sort = requestSort.value;
    var group = requestGroup.value; var angle = requestAngle.value;
    var input = omniBox.value; var output = "";
    if (input.includes('macros ')) {
        document.getElementById('omniBox').value = macrosSequence(input, 'macros ');
    } else if (input.includes('MACROS ')) {
        document.getElementById('omniBox').value = macrosSequence(input, 'MACROS ');
    } else if (input.includes('exec ')) {
        document.getElementById('omniBox').value = macrosSequence(input, 'exec ');
    } else if (input.includes('EXEC ')) {
        document.getElementById('omniBox').value = macrosSequence(input, 'EXEC ');
    } else if (input.includes('set ')) {
        document.getElementById('omniBox').value = macrosSequence(input, 'set ');
    } else if (input.includes('SET ')) {
        document.getElementById('omniBox').value = macrosSequence(input, 'SET ');
    } else if (input.includes('get ')) {
        getPkgSequence(input, 'get ', 0);
    } else if (input.includes('git ')) {
        getPkgSequence(input, 'git ', 1);
    } else if (input.includes('GET ')) {
        getPkgSequence(input, 'GET ', 0);
    } else if (input.includes('GIT ')) {
        getPkgSequence(input, 'GIT ', 1);
    } else {
        document.getElementById('omniBox').value = eval(input);
    } document.getElementById('omniBox').focus();
}
</script>
