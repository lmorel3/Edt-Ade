/*

    Edt - Lyon1 by Laurent MOREL - 2014
    (Licensed under Creative Commons CC-BY-NC)

*/

var ressource = 9303;
if(location.search.length > 0){
    switch(location.search){
        case "?ben":
            ressource = 32438;
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