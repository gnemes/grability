function Matrix(size, operations) {
    this.size = size; // Tamaño de la matriz
    this.operations = operations; // Cantidad de operaciones sobre la matriz
}

function Container()
{
    this.matrix = new Array(); // Contenedor de matrices
}

Container.prototype.addMatrix = function(matrix) {
    this.matrix.push(matrix);
};