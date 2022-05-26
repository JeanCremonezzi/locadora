export function getPessoas() {
     return $.ajax({
        url: "http://localhost/locadora/webservice/routes/pessoasRoute.php",
        type: "GET",
        dataType: "json"
    });
}