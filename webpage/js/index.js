import { getPessoas } from "./api/pessoas.js";
import { tablePessoas } from "./components/tablePessoas.js";

$(() => {
    let pessoasAnchor = $("#pessoasAnchor");
    let carrosAnchor = $("#carrosAnchor");
    let mainContainer = $("#mainContainer");

    $(pessoasAnchor).click((e) => {
        e.preventDefault();

        $(carrosAnchor).removeClass("active");
        $(carrosAnchor).removeAttr("aria-current");

        $(pessoasAnchor).addClass("active");
        $(pessoasAnchor).attr("aria-current", "page");

        $(mainContainer).empty();

        getPessoas().then(res => {
            $(mainContainer).append(tablePessoas(res.data));
        })
        .catch((res) => {
            console.log(res.responseJSON);
        });
    });

    $(carrosAnchor).click((e) => {
        e.preventDefault();

        $(pessoasAnchor).removeClass("active");
        $(pessoasAnchor).removeAttr("aria-current");

        $(carrosAnchor).addClass("active");
        $(carrosAnchor).attr("aria-current", "page");

        $(mainContainer).empty();
    });
});