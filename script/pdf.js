function genPDF(){

    var doc = new jsPDF();

    doc.fromHTML($("#body").get(0), 20, 20, {
        "width" : 500
    });

    doc.save("Test.pdf");
}