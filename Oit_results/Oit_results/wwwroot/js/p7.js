let contacts = []
let showContact = []
function addContact(){
    let form_name = document.forms['add-contact-form']['contact-name'].value
    let form_number = document.forms['add-contact-form']['contact-number'].value
    console.log(form_name + ':' + form_number)

    contacts.push({
        name: form_name,
        number: form_number
    })
    console.log(contacts)
    removeAll();
    showContacts(contacts);
}
function searchContact(){
    let searchValue = document.getElementById("search").value;
    let resultContacts = contacts.filter((contact) => contact.name.includes(searchValue))
    removeAll();
    showContacts(resultContacts);
}
function removeAll(){
    var elements = document.getElementsByClassName('div-contact-element');
    console.log("Remove all elements. Count = " + elements.length);
    console.log("Remove all showContact elements. Count = " + showContact.length);
    for (let child of showContact) {
        child.remove();
    }
    showContact = [];
}
function showContacts(contacts){

    for (var element of contacts) {
        createContact(element);
    }
}
function createContact(contact){
    
    var div = document.createElement("div");
    var name_a = document.createElement("a");
    var number_a = document.createElement("a");
    var button = document.createElement("button");
    div.classList.add("div-contact-element");
    name_a.innerHTML = contact.name;
    name_a.classList.add("name");
    number_a.innerHTML = contact.number;
    number_a.classList.add("number");
    button.innerHTML = 'Удалить';
    button.classList.add("button");
    button.onclick = function (){
        RemoveContact(contact, div);
    }
    div.appendChild(name_a);
    div.appendChild(number_a);
    div.appendChild(button);
    var contenct = document.getElementById('content');
    contenct.appendChild(div);
    showContact.push(div);
}
function RemoveContact(contact, divcontact){
    const index = contacts.indexOf(contact);
    if (index > -1) { // only splice array when item is found
        contacts.splice(index, 1); // 2nd parameter means remove one item only
        divcontact.remove();
    }
    else{
        console.error("contact not found")
    }
}