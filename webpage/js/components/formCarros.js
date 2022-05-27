import { insertCarros } from "../api/carros.js";
import { editCarros } from "../api/carros.js";
import { getPessoas } from "../api/pessoas.js";

export function formAddCarros() {
    let form = $("<form>").addClass("w-75").attr("id", "formAddCarros");
    let title = $("<span>").text("Adicionar carro").addClass("fw-bold text-uppercase");

    let nomeGroup = $("<div>").addClass("mb-3");
    let nomeLabel = $("<label>").addClass("form-label").attr("for", "nomeCarro").text("Nome");
    let nomeInput = $("<input>").addClass("form-control w-75").attr({
        "type": "text", 
        "id": "nomeCarro", 
        "name": "nome", 
        "placeholder": "Nome"
    });

    let marcaGroup = $("<div>").addClass("mb-3");
    let marcaLabel = $("<label>").addClass("form-label").attr("for", "marcaCarro").text("Marca");
    let marcaInput = $("<input>").addClass("form-control w-75").attr({
        "type": "text", 
        "id": "marcaCarro", 
        "name": "marca", 
        "placeholder": "Marca do carro"
    });

    let anoGroup = $("<div>").addClass("mb-3");
    let anoLabel = $("<label>").addClass("form-label").attr("for", "anoCarro").text("Ano");
    let anoInput = $("<input>").addClass("form-control w-75").attr({
        "type": "number", 
        "id": "anoCarro", 
        "name": "ano",
        "step": "1",
        "min": "1900",
        "value": new Date().getFullYear()
    });

    let btnSubmit = $("<button>").attr("type", "submit").addClass("btn btn-success fw-bold text-uppercase").text("Adicionar");

    let pessoaGroup = $("<div>").addClass("mb-3");
    let pessoaLabel = $("<label>").addClass("form-label").attr("for", "pessoaCarro").text("Pessoa");
    let pessoaInput = genSelect(btnSubmit).addClass("w-75")
    .attr({
        "name":"pessoa",
        "id":"pessoaCarro"
    });

    $(btnSubmit).click((e) => {
        e.preventDefault();
        handleSubmitAdd();
    });

    $(form).append(title);

    $(nomeGroup).append(nomeLabel);
    $(nomeGroup).append(nomeInput);
    $(form).append(nomeGroup);

    $(marcaGroup).append(marcaLabel);
    $(marcaGroup).append(marcaInput);
    $(form).append(marcaGroup);

    $(anoGroup).append(anoLabel);
    $(anoGroup).append(anoInput);
    $(form).append(anoGroup);

    $(pessoaGroup).append(pessoaLabel);
    $(pessoaGroup).append(pessoaInput);
    $(form).append(pessoaGroup);

    $(form).append(btnSubmit);

    return form;
}

export function formEditCarros(carro) {
    let form = $("<form>").addClass("w-75").attr("id", "formEditCarros");
    let title = $("<span>").text("Editar carro").addClass("fw-bold text-uppercase");

    let nomeGroup = $("<div>").addClass("mb-3");
    let nomeLabel = $("<label>").addClass("form-label").attr("for", "nomeCarroEdit").text("Nome");
    let nomeInput = $("<input>").addClass("form-control w-75").attr({
        "type": "text", 
        "id": "nomeCarroEdit", 
        "name": "nome", 
        "placeholder": "Nome",
        "value": carro.nome
    });

    let marcaGroup = $("<div>").addClass("mb-3");
    let marcaLabel = $("<label>").addClass("form-label").attr("for", "marcaCarroEdit").text("Marca");
    let marcaInput = $("<input>").addClass("form-control w-75").attr({
        "type": "text", 
        "id": "marcaCarroEdit", 
        "name": "marca", 
        "placeholder": "Marca do carro",
        "value": carro.marca
    });

    let anoGroup = $("<div>").addClass("mb-3");
    let anoLabel = $("<label>").addClass("form-label").attr("for", "anoCarroEdit").text("Ano");
    let anoInput = $("<input>").addClass("form-control w-75").attr({
        "type": "number", 
        "id": "anoCarroEdit", 
        "name": "ano",
        "step": "1",
        "min": "1900",
        "value": carro.ano
    });

    let btnEdit = $("<button>").attr("type", "submit").addClass("btn btn-warning fw-bold text-uppercase").text("Editar");

    $(btnEdit).click((e) => {
        e.preventDefault();
        handleSubmitEdit(carro.id);
    })

    let pessoaGroup = $("<div>").addClass("mb-3");
    let pessoaLabel = $("<label>").addClass("form-label").attr("for", "pessoaCarroEdit").text("Pessoa");
    let pessoaInput = genSelectEdit(btnEdit, carro.idPessoa).addClass("w-75")
    .attr({
        "name":"pessoa",
        "id":"pessoaCarroEdit"
    });
    
    let btnVoltarAdicionar = $("<button>").attr("type", "button").addClass("d-block btn btn-dark fw-bold text-uppercase mb-3").text("Voltar a adicionar");
    
    $(btnVoltarAdicionar).click(() => {
        $("#forms").empty();
        $("#forms").append(formAddCarros());
    });

    $(form).append(btnVoltarAdicionar);

    $(form).append(title);

    $(nomeGroup).append(nomeLabel);
    $(nomeGroup).append(nomeInput);
    $(form).append(nomeGroup);

    $(marcaGroup).append(marcaLabel);
    $(marcaGroup).append(marcaInput);
    $(form).append(marcaGroup);

    $(anoGroup).append(anoLabel);
    $(anoGroup).append(anoInput);
    $(form).append(anoGroup);

    $(pessoaGroup).append(pessoaLabel);
    $(pessoaGroup).append(pessoaInput);
    $(form).append(pessoaGroup);

    $(form).append(btnEdit);

    return form; 
}

const genSelect = (btn) => {
    let select = $("<select>").addClass("form-select");
    
    getPessoas().then(res => {
        const pessoas = res.data;

        pessoas.map((pessoa) => {
            let option = $("<option>").attr("value", pessoa.id).text(pessoa.nome);

            $(select).append(option);
        });
    })
    .catch((res) => {
        let option = $("<option>").text("Nenhuma pessoa encontrada");
        $(option).attr("selected", true);

        $(select).attr("disabled", true);
        $(btn ).attr("disabled", true);
        $(select).append(option);
    });

    return select;
}

const genSelectEdit = (btn, idPessoa) => {
    let select = $("<select>").addClass("form-select");
    
    getPessoas().then(res => {
        const pessoas = res.data;

        pessoas.map((pessoa) => {
            let option = $("<option>").attr("value", pessoa.id).text(pessoa.nome);

            if (pessoa.id == idPessoa) {
                $(option).attr("selected", true);
            };

            $(select).append(option);
        });
    })
    .catch((res) => {
        let option = $("<option>").text("Nenhuma pessoa encontrada");
        $(option).attr("selected", true);

        $(select).attr("disabled", true);
        $(btn ).attr("disabled", true);
        $(select).append(option);
    });

    return select;
}

const handleSubmitAdd = () => {
    let nome = $("#nomeCarro").val();
    let marca = $("#marcaCarro").val();
    let ano = $("#anoCarro").val();
    let pessoa = $("#pessoaCarro").val();

    const data = {
        nome: nome,
        marca: marca,
        ano: ano,
        idPessoa: pessoa
    }

    insertCarros(data).then((res) => {
        $("#myModal").modal("hide");

        $("#alertModal").modal("show");
        $("#alertModalTitle").text("Requisição concluída");
        $("#alertModalBody").text(res.msg);
    }).catch((res) => {
        $("#myModal").modal("hide");

        $("#alertModal").modal("show");
        $("#alertModalTitle").text("Requisição falhou");
        $("#alertModalBody").text(res.responseJSON.msg);
    });
};

const handleSubmitEdit = (id) => {
    let nome = $("#nomeCarroEdit").val();
    let marca = $("#marcaCarroEdit").val();
    let ano = $("#anoCarroEdit").val();
    let idPessoa = $("#pessoaCarroEdit").val();

    const data = {
        id: id,
        nome: nome,
        marca: marca,
        ano: ano,
        idPessoa: idPessoa
    }

    editCarros(data).then((res) => {
        $("#myModal").modal("hide");

        $("#alertModal").modal("show");
        $("#alertModalTitle").text("Requisição concluída");
        $("#alertModalBody").text(res.msg);
    }).catch((res) => {
        $("#myModal").modal("hide");

        $("#alertModal").modal("show");
        $("#alertModalTitle").text("Requisição falhou");
        $("#alertModalBody").text(res.responseJSON.msg);
    });
}