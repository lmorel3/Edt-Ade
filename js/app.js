/*

    Edt - Lyon1 by Laurent MOREL - 2014
    (Licensed under Creative Commons CC-BY-NC)

*/

$('#calendar').fullCalendar({

    eventSources: [

        {
            url: 'rss.php',
            type: 'POST',
            //cache: true,
            data: {
                ressourceId: '9300', // RessourceID
            },
            error: function() {
                alert('Error during fetching datas...');
            },
            textColor: 'black' // a non-ajax option*/
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