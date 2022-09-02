<!-- script type="text/javascript" src="https://www.google.com/jsapi"></script-->

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.11/c3.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.pt.min.js"></script>

<!--script src="https://pivottable.js.org/dist/gchart_renderers.js"></script-->
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.6.0/tips_data.min.js"></script-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.12.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.11/c3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/c3_renderers.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/export_renderers.min.js"></script>


<style>
.container{
  clear: both;
  max-width: 100%;
}
table{
  width:auto;
}
input.pvtSearch{
  margin: auto;
}
.pvtFilterBox button{
  padding: 5px;
  margin: 2px;
}
select {
     width: auto;
}
table td {
    word-break:normal;
}
.pvtHorizList {
  vertical-align: middle;
}
.pvtRowLabel{
  vertical-align: top;
}
</style>

<div  style="display:inline-block; vertical-align: top;margin-bottom: 10px;">
<input type="button" id ="Imprimir" value ="Imprimir" />
<input type="button" id ="Filtros" value ="Ocultar Filtros" />
<input type="button" id ="Total" value ="Ocultar Totais" />
</div>
<div id="output"><img src="<?=$this->request->webroot?>img/ajax-loader.gif" style="margin:auto; padding: 100px;" />Carregando Dados</div>

<script>
 //google.load("visualization", "1", {packages:["corechart", "charteditor"]});

//var derivers = $.pivotUtilities.derivers;
var renderers = $.extend(
    	$.pivotUtilities.renderers,
      $.pivotUtilities.c3_renderers,
	  $.pivotUtilities.export_renderers
    )

$.ajaxSetup({
    scriptCharset: "utf-8",
    contentType: "application/json; charset=utf-8"
});
$.getJSON("<?=$this->request->webroot?>json/alunos.php", function(mps) {

 $("#output").pivotUI(
   mps, {
     renderers: renderers,
    menuLimit: 10000,
    onRefresh: function(config) {
      updateTotalState();
    }
  },false, "pt")
 });
</script>

<script>

function updateTotalState(){
  if($("#Total").prop('value') == "Exibir Totais"){
    $(".pvtTotal,.pvtTotalLabel,.pvtGrandTotal").hide();
  }
  else{
    $(".pvtTotal,.pvtTotalLabel,.pvtGrandTotal").show();
  }
}
$("#Total").click(function(){
  if($("#Total").prop('value') == "Ocultar Totais"){
    $("#Total").prop('value',"Exibir Totais");
    $(".pvtTotal,.pvtTotalLabel,.pvtGrandTotal").hide();
  }
  else{
    $("#Total").prop('value',"Ocultar Totais");
    $(".pvtTotal,.pvtTotalLabel,.pvtGrandTotal").show();
  }
});
$("#Filtros").click(function(){
  if($("#Filtros").prop('value') == "Ocultar Filtros"){
    $("#Filtros").prop('value',"Exibir Filtros");
    $(".pvtAxisContainer, .pvtVals, .pvtRenderer").hide();
  }
  else{
    $("#Filtros").prop('value',"Ocultar Filtros");
    $(".pvtAxisContainer, .pvtVals, .pvtRenderer").show();
  }
});

$("#Imprimir").click(function(){

 $(".pvtAxisContainer, .pvtVals, .pvtRenderer").hide();

 var divToPrint=document.getElementById('output');

var newWin=window.open('','Print-Window');
newWin.document.open();
newWin.document.write('<html>');
newWin.document.write('<title>Projeto Dashboard - Relatório</title>');
newWin.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.13.0/pivot.min.css">');
newWin.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css">');
newWin.document.write('<body onload="window.print()">');
newWin.document.write('<div><div style="position: absolute; text-align: center; width: 100%; top:35px; text-transform:uppercase;">Projeto Dashboard</div><img src="http://www.inf.puc-rio.br/wordpress/wp-content/themes/puc-di/assets/img/theme/logo_puc.png" style="float:right;" />');
newWin.document.write('<img src="http://www.inf.puc-rio.br/wordpress/wp-content/themes/puc-di/assets/img/theme/logo.png" /></div>');
newWin.document.write(divToPrint.innerHTML);
newWin.document.write('</body>');
newWin.document.write('</html>');
newWin.document.close();

setTimeout(function(){newWin.close(); $(".pvtAxisContainer, .pvtVals, .pvtRenderer").show();},10);


});
</script>
