import { deletePessoa } from "../api/pessoas.js";
import { formEditPessoas } from "../components/formPessoas.js";

export function tablePessoas(pessoas) {
    let tableResponsive = $("<div>").addClass("table-responsive w-100");

    let table = $("<table>").addClass("table table-hover table-bordered caption-top");
    let caption = $("<caption>").text("Lista de Pessoas");

    let thead = $("<thead>").addClass("table-dark");
    let tr = $("<tr>");

    let thNome = $("<th>").attr("scope", "col").text("Nome").addClass("text-center");
    let thLogin = $("<th>").attr("scope", "col").text("Login").addClass("text-center");
    let thSenha = $("<th>").attr("scope", "col").text("Senha").addClass("text-center");
    let thCarros = $("<th>").attr("scope", "col").text("Carros").addClass("text-center");
    let thDeletar = $("<th>").attr("scope", "col").text("Deletar").addClass("text-center");
    let thEditar = $("<th>").attr("scope", "col").text("Editar").addClass("text-center");

    $(tr).append(thNome, thLogin, thSenha, thCarros, thDeletar, thEditar);
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
    let tdNome = $("<td>").text(pessoa.nome).addClass("text-center align-middle");
    let tdLogin = $("<td>").text(pessoa.login).addClass("text-center align-middle");
    let tdSenha = $("<td>").text(pessoa.senha).addClass("text-center align-middle");

    let tdCarros = $("<td>").addClass("text-center align-middle");
    let btnCarros = $("<button>").addClass("btn btn-primary fw-bold text-uppercase").text("Ver carros");
    $(tdCarros).append(btnCarros);

    let tdDeletar = $("<td>").addClass("text-center align-middle");
    let btnDeletar = $("<button>").addClass("btn btn-danger fw-bold text-uppercase").text("Deletar");
    $(btnDeletar).click((e) => {handleDelete(e, pessoa.id, pessoa.nome)});
    $(tdDeletar).append(btnDeletar);

    let tdEditar = $("<td>").addClass("text-center align-middle");
    let btnEditar = $("<button>").addClass("btn btn-warning fw-bold text-uppercase").text("Editar");

    $(btnEditar).click(() => {
        $("#forms").empty();
        $("#forms").append(formEditPessoas(pessoa));
        $("html, body").animate({ scrollTop: 0 }, "fast");
    })

    $(tdEditar).append(btnEditar);
    
    $(row).append(tdNome, tdLogin, tdSenha, tdCarros, tdDeletar, tdEditar);

    return row;
}

const handleDelete = (e, id, nome) => {
    e.preventDefault();

    $("#myModal").modal("show");
    $("#myModalTitle").text("Deletar pessoa");
    $("#myModalBody").text("Você tem certeza que deseja deletar '" + nome + "'?");

    $("#myModalConfirm").off("click");
    $("#myModalConfirm").click((e) => {
        e.preventDefault();

        $("#myModalConfirm").off("click");

        deletePessoa(id).then(res => {
            $("#myModal").modal("hide");

            $("#alertModal").modal("show");
            $("#alertModalTitle").text("Requisição concluída");
            $("#alertModalBody").text(res.msg);
        })
        .catch((res) => {
            $("#myModal").modal("hide");

            $("#alertModal").modal("show");
            $("#alertModalTitle").text("Requisição falhou");
            $("#alertModalBody").text(res.responseJSON.msg);
        });
    });
}