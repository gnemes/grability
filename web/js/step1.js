$("#next-step").on('click', function( event ) {
    var tc = new TestCases();
    tc.quantity = $("#testsqty").val();

    var jsonTestCases = JSON.stringify(tc);

    alert(jsonTestCases);
});