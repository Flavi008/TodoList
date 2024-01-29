
//JavaScript das auf Checkbox reargiert und Klasse hidden bei erledigten Todos hinzufügt und entfernt
// JavaSript wird vom Broweser ausgegührt 
console.log("hallo");
document.addEventListener('DOMContentLoaded' , function (){
// Wurde ausgeführt wenn Browser DOM (Seite) geladen hat

// HTML Elemente referenzieren 
const showCompletedCheckbox = document.getElementById("showCompleted");   // Zugriff auf Todo Liste in JS
const todoList = document.getElementById("todoList");   // Zugriff auf Todo Liste in JS   

// Suche im HTML Code nach den Kindern von todoListe die die KLasse status_erledigt haben 
const todosErledigt = todoList.querySelectorAll('.status_erledigt');

// Reargieren auf Input an Checkbox 
showCompletedCheckbox.addEventListener ('change' , function(){
// Wurde ausgeführt wenn status checkbox sich ändert 

//Frage den Status der Checkbox ab 
if(showCompletedCheckbox.checked) {
// Checkbox is chhecked

// Klasse hidden entfernen von allen erledigten Todos 
todosErledigt.forEach( row => 
{row.classList.remove('hidden')});
}else {
// Checkbox ist not checked 

// KLasse hidden hinzufügen zu allen erledigten Todos 
todosErledigt.forEach( row => 
{row.classList.add('hidden')});
}

});
}); // Ende addEventlistener

