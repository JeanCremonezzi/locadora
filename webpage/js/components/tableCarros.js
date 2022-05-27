import { deleteCarros } from "../api/carros.js";
import { formEditCarros } from "../components/formCarros.js";

export function tableCarros(carros) {
    let tableResponsive = $("<div>").addClass("table-responsive w-100");

    let table = $("<table>").addClass("table table-hover table-bordered caption-top");
    let caption = $("<caption>").text("Lista de Carros");

    let thead = $("<thead>").addClass("table-dark");
    let tr = $("<tr>");

    let thNome = $("<th>").attr("scope", "col").text("Nome").addClass("text-center");
    let thMarca = $("<th>").attr("scope", "col").text("Marca").addClass("text-center");
    let thAno = $("<th>").attr("scope", "col").text("Ano").addClass("text-center");
    let thPessoa = $("<th>").attr("scope", "col").text("Pessoa").addClass("text-center");
    let thDeletar = $("<th>").attr("scope", "col").text("Deletar").addClass("text-center");
    let thEditar = $("<th>").attr("scope", "col").text("Editar").addClass("text-center");

    $(tr).append(thNome, thMarca, thAno, thPessoa, thDeletar, thEditar);
    $(thead).append(tr);

    let tbody = $("<tbody>");
    
    carros.map(carro => {
        $(tbody).append(genRow(carro));
    });

    table.append(caption);
    table.append(thead);
    table.append(tbody);

    $(tableResponsive).append(table);

    return tableResponsive;
}

const genRow = (carro) => {
    let row = $("<tr>");
    let tdNome = $("<td>").text(carro.nome).addClass("text-center align-middle");
    let tdMarca = $("<td>").text(carro.marca).addClass("text-center align-middle");
    let tdAno = $("<td>").text(carro.ano).addClass("text-center align-middle");
    let tdPessoa = $("<td>").text(carro.pessoa).addClass("text-center align-middle");

    let tdDeletar = $("<td>").addClass("text-center align-middle");
    let btnDeletar = $("<button>").addClass("btn btn-danger fw-bold text-uppercase").text("Deletar");
    $(btnDeletar).click((e) => {handleDelete(e, carro.id, carro.nome)});
    $(tdDeletar).append(btnDeletar);

    let tdEditar = $("<td>").addClass("text-center align-middle");
    let btnEditar = $("<button>").addClass("btn btn-warning fw-bold text-uppercase").text("Editar");

    $(btnEditar).click(() => {
        $("#forms").empty();
        $("#forms").append(formEditCarros(carro));
        $("html, body").animate({ scrollTop: 0 }, "fast");
    })

    $(tdEditar).append(btnEditar);
    
    $(row).append(tdNome, tdMarca, tdAno, tdPessoa, tdDeletar, tdEditar);

    return row;
}

const handleDelete = (e, id, nome) => {
    e.preventDefault();

    $("#myModal").modal("show");
    $("#myModalTitle").text("Deletar carro");
    $("#myModalBody").text("Você tem certeza que deseja deletar '" + nome + "'?");

    $("#myModalConfirm").off("click");
    $("#myModalConfirm").click((e) => {
        e.preventDefault();

        $("#myModalConfirm").off("click");

       deleteCarros(id).then(res => {
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