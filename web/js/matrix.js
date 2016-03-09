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