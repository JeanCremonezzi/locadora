import { insertPessoa } from "../api/pessoas.js";
import { editPessoa } from "../api/pessoas.js";

export function formAddPessoas() {
    let form = $("<form>").addClass("w-75").attr("id", "formAddPessoas");
    let title = $("<span>").text("Adicionar pessoa").addClass("fw-bold text-uppercase");

    let nomeGroup = $("<div>").addClass("mb-3");
    let nomeLabel = $("<label>").addClass("form-label").attr("for", "nomePessoa").text("Nome");
    let nomeInput = $("<input>").addClass("form-control w-75").attr({
        "type": "text", 
        "id": "nomePessoa", 
        "name": "nome", 
        "placeholder": "Nome"
    });

    let loginGroup = $("<div>").addClass("mb-3");
    let loginLabel = $("<label>").addClass("form-label").attr("for", "emailPessoa").text("Email");
    let loginInput = $("<input>").addClass("form-control w-75").attr({
        "type": "email", 
        "id": "emailPessoa", 
        "name": "login", 
        "placeholder": "User@mail.com"
    });

    let senhaGroup = $("<div>").addClass("mb-3");
    let senhaLabel = $("<label>").addClass("form-label").attr("for", "senhaPessoa").text("Senha");
    let senhaInput = $("<input>").addClass("form-control w-75").attr({
        "type": "text", 
        "id": "senhaPessoa", 
        "name": "senha", 
        "placeholder": "Password"
    });

    let btnSubmit = $("<button>").attr("type", "submit").addClass("btn btn-success fw-bold text-uppercase").text("Adicionar");

    $(btnSubmit).click((e) => {
        e.preventDefault();
        handleSubmitAdd();
    })

    $(form).append(title);

    $(nomeGroup).append(nomeLabel);
    $(nomeGroup).append(nomeInput);
    $(form).append(nomeGroup);

    $(loginGroup).append(loginLabel);
    $(loginGroup).append(loginInput);
    $(form).append(loginGroup);

    $(senhaGroup).append(senhaLabel);
    $(senhaGroup).append(senhaInput);
    $(form).append(senhaGroup);

    $(form).append(btnSubmit);

    return form;
}

export function formEditPessoas(pessoa) {
    let form = $("<form>").addClass("w-75").attr("id", "formEditPessoas");
    let title = $("<span>").text("Editar pessoa").addClass("fw-bold text-uppercase");

    let nomeGroup = $("<div>").addClass("mb-3");
    let nomeLabel = $("<label>").addClass("form-label").attr("for", "nomePessoaEdit").text("Nome");
    let nomeInput = $("<input>").addClass("form-control w-75").attr({
        "type": "text", 
        "id": "nomePessoaEdit", 
        "name": "nome", 
        "placeholder": "Nome",
        "value": pessoa.nome
    });

    let loginGroup = $("<div>").addClass("mb-3");
    let loginLabel = $("<label>").addClass("form-label").attr("for", "emailPessoaEdit").text("Email");
    let loginInput = $("<input>").addClass("form-control w-75").attr({
        "type": "email", 
        "id": "emailPessoaEdit", 
        "name": "login", 
        "placeholder": "User@mail.com",
        "value": pessoa.login
    });

    let senhaGroup = $("<div>").addClass("mb-3");
    let senhaLabel = $("<label>").addClass("form-label").attr("for", "senhaPessoaEdit").text("Senha");
    let senhaInput = $("<input>").addClass("form-control w-75").attr({
        "type": "text", 
        "id": "senhaPessoaEdit", 
        "name": "senha", 
        "placeholder": "Password",
        "value": pessoa.senha
    });

    let btnEdit = $("<button>").attr("type", "submit").addClass("btn btn-warning fw-bold text-uppercase").text("Editar");

    $(btnEdit).click((e) => {
        e.preventDefault();
        handleSubmitEdit(pessoa.id);
    })

    let btnVoltarAdicionar = $("<button>").attr("type", "button").addClass("d-block btn btn-dark fw-bold text-uppercase mb-3").text("Voltar a adicionar");
    
    $(btnVoltarAdicionar).click(() => {
        $("#forms").empty();
        $("#forms").append(formAddPessoas());
    });

    $(form).append(btnVoltarAdicionar);

    $(form).append(title);

    $(nomeGroup).append(nomeLabel);
    $(nomeGroup).append(nomeInput);
    $(form).append(nomeGroup);

    $(loginGroup).append(loginLabel);
    $(loginGroup).append(loginInput);
    $(form).append(loginGroup);

    $(senhaGroup).append(senhaLabel);
    $(senhaGroup).append(senhaInput);
    $(form).append(senhaGroup);

    $(form).append(btnEdit);

    return form;
}

const handleSubmitAdd = () => {
    let nome = $("#nomePessoa").val();
    let login = $("#emailPessoa").val();
    let senha = $("#senhaPessoa").val();

    const data = {
        nome: nome,
        login: login,
        senha: senha
    }

    insertPessoa(data).then((res) => {
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
    let nome = $("#nomePessoaEdit").val();
    let login = $("#emailPessoaEdit").val();
    let senha = $("#senhaPessoaEdit").val();

    const data = {
        id: id,
        nome: nome,
        login: login,
        senha: senha
    }

    editPessoa(data).then((res) => {
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