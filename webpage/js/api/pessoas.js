export function getPessoas() {
	return $.ajax({
		url: "http://127.0.0.1/locadora/webservice/routes/pessoasRoute.php",
		type: "GET",
		dataType: "json",
	});
}

export function deletePessoa(id) {
	return $.ajax({
		url: "http://localhost/locadora/webservice/routes/pessoasRoute.php",
		type: "DELETE",
		dataType: "json",
		data: {
			id: id,
		}
	});
}

export function insertPessoa(data) {
	return $.ajax({
		url: "http://localhost/locadora/webservice/routes/pessoasRoute.php",
		type: "POST",
		dataType: "json",
		data: data,
	});
}

export function editPessoa(data) {
	return $.ajax({
		url: "http://localhost/locadora/webservice/routes/pessoasRoute.php",
		type: "PUT",
		dataType: "json",
		data: data,
	});
}