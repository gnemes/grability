function Matrix(size, operations) {
    this.size = size; // Tamaño de la matriz
    this.operations = operations; // Cantidad de operaciones sobre la matriz
}

function TestCases()
{
    this.quantity = 0; // Test cases quantity
    this.matrices = new Array(); // Matrices del test case
}

TestCases.prototype.addMatriz = function(matrix) {
    this.matrices.push(matrix);
};

function submitTestCase(tc)
{
    var jsonTestCases = JSON.stringify(tc);
    jsonTestCases = jsonTestCases.replace(/(['"])/g, "\\$1");
alert(jsonTestCases);
    var input = "<input type='hidden' name='testCase' value=\""+jsonTestCases+"\"/>";

    $("#form-step").append(input).submit();    
}