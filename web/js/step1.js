$("#next-step").on('click', function( event ) {
    alert("Inicio");
    var testCases = new TestCases();
    testCases.quantity = $("#testsqty").val();
    
    var jsonTestCases = JSON.stringify(testCases);
    
    alert(jsonTestCases);
});