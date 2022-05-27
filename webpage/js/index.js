import { getPessoas } from "./api/pessoas.js";
import { getCarros } from "./api/carros.js";
import { tablePessoas } from "./components/tablePessoas.js";
import { tableCarros } from "./components/tableCarros.js";
import { alertBox } from "./components/alertBox.js";
import { formAddPessoas } from "./components/formPessoas.js";
import { formAddCarros } from "./components/formCarros.js";

$(() => {
    let pessoasAnchor = $("#pessoasAnchor");
    let carrosAnchor = $("#carrosAnchor");
    let mainContainer = $("#mainContainer");

    $("#forms").append(formAddPessoas());
    getPessoas().then(res => {
        $(mainContainer).append(tablePessoas(res.data));
    })
    .catch((res) => {
        $(mainContainer).append(alertBox(res.responseJSON.msg));
    });

    $(pessoasAnchor).click((e) => {
        e.preventDefault();

        $(carrosAnchor).removeClass("active");
        $(carrosAnchor).removeAttr("aria-current");

        $(pessoasAnchor).addClass("active");
        $(pessoasAnchor).attr("aria-current", "page");

        $(mainContainer).empty();

        $("#forms").empty();
        $("#forms").append(formAddPessoas());
        getPessoas().then(res => {
            $(mainContainer).append(tablePessoas(res.data));
        })
        .catch((res) => {
            $(mainContainer).append(alertBox(res.responseJSON.msg));
        });
    });

    $(carrosAnchor).click((e) => {
        e.preventDefault();

        $(pessoasAnchor).removeClass("active");
        $(pessoasAnchor).removeAttr("aria-current");

        $(carrosAnchor).addClass("active");
        $(carrosAnchor).attr("aria-current", "page");

        $(mainContainer).empty();
        
        $("#forms").empty();
        $("#forms").append(formAddCarros());
        getCarros().then(res => {
            $(mainContainer).append(tableCarros(res.data));
        })
        .catch((res) => {
            $(mainContainer).append(alertBox(res.responseJSON.msg));
        });
    });

    $("#alertModal").on('hidden.bs.modal', () => {
        location.reload();
    })
});