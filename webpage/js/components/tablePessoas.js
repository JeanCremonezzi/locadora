export function tablePessoas(pessoas) {
    let tableResponsive = $("<div>").addClass("table-responsive w-100");

    let table = $("<table>").addClass("table table-hover table-bordered caption-top");
    let caption = $("<caption>").text("Lista de Pessoas");

    let thead = $("<thead>").addClass("table-dark");
    let tr = $("<tr>");

    let thNome = $("<th>").attr("scope", "col").text("Nome").addClass("text-center");
    let thLogin = $("<th>").attr("scope", "col").text("Login").addClass("text-center");
    let thSenha = $("<th>").attr("scope", "col").text("Senha").addClass("text-center");

    $(tr).append(thNome, thLogin, thSenha);
    $(thead).append(tr);

    let tbody = $("<tbody>");
    
    pessoas.map(pessoa => {
        $(tbody).append(genRow(pessoa));
    });

    table.append(caption);
    table.append(thead);
    table.append(tbody);

    $(tableResponsive).append(table);

    return tableResponsive;
}

const genRow = (pessoa) => {
    let row = $("<tr>");
    let tdNome = $("<td>").text(pessoa.nome).addClass("text-center");
    let tdLogin = $("<td>").text(pessoa.login).addClass("text-center");
    let tdSenha = $("<td>").text(pessoa.senha).addClass("text-center");
    
    $(row).append(tdNome, tdLogin, tdSenha);

    return row;
}