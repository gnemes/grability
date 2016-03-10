function Matrix(size, operations) {
    this.size = size; // Tamaño de la matriz
    this.operations = operations; // Cantidad de operaciones sobre la matriz
}

function TestCases()
{
    this.quantity = 0; // Test cases quantity
    this.matrices = new Array(); // Matrices del test case
}

TestCases.prototype.addMatrix = function(matrix) {
    this.matrices.push(matrix);
};

TestCases.prototype.removeMatrices = function() {
    this.matrices = new Array();
}

TestCases.prototype.init = function(jsonTestCases) {
    // Parse init JSON string
    var tcTmp = jQuery.parseJSON(jsonTestCases);
    
    // Set test cases quantity
    this.quantity = tcTmp.quantity;
    
    // Add matrices to test case
    for (var i in tcTmp.matrices) {
        this.addMatrix(new Matrix(tcTmp.matrices[i].size, tcTmp.matrices[i].operations));
    }
}

function dump(obj) {
    var out = '';
    for (var i in obj) {
        if (typeof obj[i] === 'object') {
            dump(obj[i]);
        }
        out += i + ": " + obj[i] + "\n";
    }

    //alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}

function submitTestCase(tc)
{
    var jsonTestCases = htmlspecialchars(JSON.stringify(tc));

    var input = "<input type='hidden' name='testCase' value=\""+jsonTestCases+"\"/>";

    $("#form-step").append(input).submit();    
}

function htmlspecialchars(string, quote_style, charset, double_encode) {
  //       discuss at: http://phpjs.org/functions/htmlspecialchars/
  //      original by: Mirek Slugen
  //      improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //      bugfixed by: Nathan
  //      bugfixed by: Arno
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //       revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //         input by: Ratheous
  //         input by: Mailfaker (http://www.weedem.fr/)
  //         input by: felix
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  //             note: charset argument not supported
  //        example 1: htmlspecialchars("<a href='test'>Test</a>", 'ENT_QUOTES');
  //        returns 1: '&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;'
  //        example 2: htmlspecialchars("ab\"c'd", ['ENT_NOQUOTES', 'ENT_QUOTES']);
  //        returns 2: 'ab"c&#039;d'
  //        example 3: htmlspecialchars('my "&entity;" is still here', null, null, false);
  //        returns 3: 'my &quot;&entity;&quot; is still here'

  var optTemp = 0,
    i = 0,
    noquotes = false;
  if (typeof quote_style === 'undefined' || quote_style === null) {
    quote_style = 2;
  }
  string = string.toString();
  if (double_encode !== false) { // Put this first to avoid double-encoding
    string = string.replace(/&/g, '&amp;');
  }
  string = string.replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');

  var OPTS = {
    'ENT_NOQUOTES': 0,
    'ENT_HTML_QUOTE_SINGLE': 1,
    'ENT_HTML_QUOTE_DOUBLE': 2,
    'ENT_COMPAT': 2,
    'ENT_QUOTES': 3,
    'ENT_IGNORE': 4
  };
  if (quote_style === 0) {
    noquotes = true;
  }
  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
    quote_style = [].concat(quote_style);
    for (i = 0; i < quote_style.length; i++) {
      // Resolve string input to bitwise e.g. 'ENT_IGNORE' becomes 4
      if (OPTS[quote_style[i]] === 0) {
        noquotes = true;
      } else if (OPTS[quote_style[i]]) {
        optTemp = optTemp | OPTS[quote_style[i]];
      }
    }
    quote_style = optTemp;
  }
  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
    string = string.replace(/'/g, '&#039;');
  }
  if (!noquotes) {
    string = string.replace(/"/g, '&quot;');
  }

  return string;
}