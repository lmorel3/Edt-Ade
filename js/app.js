/*

    Edt - Lyon1 by Laurent MOREL - 2014-2015
    (Licensed under Creative Commons CC-BY-NC)

*/

var ressource = 9303;
var univ = "lyon1";

if(location.search.length > 0){
    switch(location.search){
        case "?test":
            ressource = 32438;
            break;
        case "?testSainte":
            ressource = 5273;
            univ = "sainte";
            break;
    }
}

$('#calendar').fullCalendar({

    eventSources: [

        {
            url: 'retriever.php',
            type: 'POST',
            data: {
                ressourceId: ressource,
                univId: univ
            },
            error: function(e) {
                alert('Error during fetching datas...');
                console.log(e);
            },
            textColor: 'black'
        }


    ],

    weekends: false,
    firstDay: 1,
    defaultView: 'agendaWeek',
    lang: 'fr',

    theme: true, // Use jQueryUI Theme

    minTime: "'08:00:00",
    maxTime: "'18:00:00",
    aspectRatio: 1.7,

    eventRender: function (event, element) {
        element.find('.fc-title').html(event.title); // Force HTML on the "title"
    }

});