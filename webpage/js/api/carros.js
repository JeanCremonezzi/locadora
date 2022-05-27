export function getCarros() {
	return $.ajax({
		url: "http://127.0.0.1/locadora/webservice/routes/carrosRoute.php",
		type: "GET",
		dataType: "json",
	});
}

export function deleteCarros(id) {
	return $.ajax({
		url: "http://localhost/locadora/webservice/routes/carrosRoute.php",
		type: "DELETE",
		dataType: "json",
		data: {
			id: id,
		}
	});
}

export function insertCarros(data) {
	return $.ajax({
		url: "http://localhost/locadora/webservice/routes/carrosRoute.php",
		type: "POST",
		dataType: "json",
		data: data,
	});
}

export function editCarros(data) {
	return $.ajax({
		url: "http://localhost/locadora/webservice/routes/carrosRoute.php",
		type: "PUT",
		dataType: "json",
		data: data,
	});
}