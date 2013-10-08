/**
*twbs js for Con-Man
*@author deddy <pheagey@gmail.com>
*@since 0.0.1
*@version 0.0.1
*@date 2013-10-04
*/

//Attach scrollspy to navbar
$('body').scrollspy({ target: '#navbar' })

//Call to refresh scrollspy navbar when adding/removing DOM elements
$('[data-spy="scroll"]').each(function () {
  var $spy = $(this).scrollspy('refresh')
})
