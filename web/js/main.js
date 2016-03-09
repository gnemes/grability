var matrixContainer = new Container;

$(function() {
    $("#next-step").hide();

    var matrixContainer = new Container();
    matrixContainer.addMatrix(new Matrix(2, 3));
    matrixContainer.addMatrix(new Matrix(4, 5));

    alert(JSON.stringify(matrixContainer.matrix));
}); 