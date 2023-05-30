const AbstractModelWithAuthHeader = async (method, serverUrl, jsonRequestModel, reqAuthHeader) => {
	console.log("We are cool");
	console.log('json Request Model:', jsonRequestModel);

	var req;
	var respData;

	//compose request:
	/*if (jsonRequestModel == '') {
		req = $.ajax({
			method: method,
			url: serverUrl,
			headers: {
				'Content-Type' : 'application/json',
				'Accept' : 'application/json',
				'Authorization': 'Bearer ' + reqAuthHeader,
			},
		});
	}
	else {
		req = $.ajax({
			method: method,
			url: serverUrl,
			data: jsonRequestModel,
			headers: {
				'Content-Type' : 'application/json',
				'Accept' : 'application/json',
				'HTTP_Authorization': 'Bearer ' + reqAuthHeader,
			},
		});
	}

	//now await response:
	await req.done((resp) => {
		//The request was made and the server responded with a status code
		//of 200
		console.log("Model: ", resp);
		respData = resp;
	});


	await req.fail((error) => {
		// The request was made and the server responded with a status code
		// that falls out of the range of 2xx
		//console.log("Response Received: ", error);
		respData = error;
	});*/

	const requestInit = {
        method: method,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: {
			'Content-Type' : 'application/json',
			'Accept' : 'application/json',
			'HTTP_Authorization': 'Bearer ' + reqAuthHeader,
		},
        body: JSON.stringify(jsonRequestModel),
    }

	const requestInitGet = {
        method: method,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: {
			'Content-Type' : 'application/json',
			'Accept' : 'application/json',
			'Authorization': 'Bearer ' + reqAuthHeader,
		},
    }


	if (jsonRequestModel == '') {
		respData = await fetch(serverUrl, requestInitGet);
	}
	else {
		respData = await fetch(serverUrl, requestInit);
	}

	return respData.json();
	//console.log("Response Received");
}

	//export default AbstractModel;



/*{
		"username" : "YoungEmmy",
		"email": "emmanueladediji@gmail.com",
		"password": "my12pass",
		"firstname": "Emmanuel",
		"lastname": "Adediji",
		
		"institution": "University of Ibadan",
		"course_of_study": "Computer Science",
		"current_school_grade": 4.50,
		"years_of_experience": 1,
		

		"skillsets": {
			"1": "Java",
			"2": "NodeJS",
			"3": "Python",
			"4": "Objective-C"
		},

		//all these can be updated after login to dashboard
		//profile picture
		/*"cover_letter": "I am cool",
		//upload picture of the internship letter
		//upload personal profile picture
		"experiences": {

			"1": {
				"jobRole" : "Engineering Intern",
				"org_name" : "Concrete Nigeria Enterprises",
				"brief_description" : "Cool Engineering Practices",
				"from" : new Date("July 30 2019"),//for DateTime:new Date(yr,mnth,day,hr,min,sec)
				"to" : new Date("December 2 2020"),
				"salary" : "",
				"perks" : "",
				"reasons_for_leaving" : ""
			},

			"2": {
				"jobRole" : "Engineering Intern",
				"org_name" : "Concrete Nigeria Enterprises",
				"brief_description" : "Cool Engineering Practices",
				"from" : new Date("July 30 2019"),//for DateTime:new Date(yr,mnth,day,hr,min,sec)
				"to" : new Date("December 2 2020"),
				"salary" : "",
				"perks" : "",
				"reasons_for_leaving" : ""
			},

			"3":{

			}

		},

		"job_preferences" : {

			"duration_range" : {
				"from": "6months",
				"to" : "1year"
			},

			"salary_range" : {
				"currency": "NGN",
				"from" : "25,000",
				"to" : "30,000"
			},

			"locations" : {
				"1" : "Ibadan",
				"2" : "Lagos",
				"3" : ""
			}
		}
}*/




