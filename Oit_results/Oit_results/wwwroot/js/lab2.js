let fieldsData = []
function Parse(){
  let datastr = document.getElementById("input_json").value;
  let jsonParse = JSON.parse(datastr);
  DeleteOutput();
  Generate(jsonParse);
  ShowFields();
}
function Generate(jsonParse){
  let form = document.createElement("form");
  form.method = jsonParse.method;
  form.action = jsonParse.action;
  
  let formInputSubmit = document.createElement("input");
  formInputSubmit.type = "submit";
  formInputSubmit.value = jsonParse.submit;
  
  let divOutput = document.getElementById("output_form");
  divOutput.appendChild(form);
  let generatedFields = GenerateFields(jsonParse.fields);
  
  fieldsData = generatedFields;
  for(f of generatedFields){
    form.appendChild(f.generatedField);
  }
  
  form.appendChild(formInputSubmit);
}
function GenerateFields(fields){
  let resFields = [];
  for(field of fields){
    let resField = GenerateField(field);
    if(resField != null) resFields.push(
      {
        inputField: field,
        generatedField: resField
      }
    );
  }
  return resFields;
}
function GenerateField(field){
  switch(field.type){
      case 'info':
        return GenerateInfo(field);
      case 'radio':
        return GenerateRadio(field);
      case 'text':
        return GenerateText(field);
      case 'textarea':
        return GenerateTextArea(field);
      case 'checkbox':
        return GenerateCheckbox(field);
      case 'password':
        return GeneratePassword(field);
    }
}

function GenerateInfo(field){
  let infoBlock = document.createElement("div");
  infoBlock.innerHTML = field.label;
  return infoBlock;
}
function GeneratePassword(field){
  let generatedField = GenerateFieldInputWithLabel('password', field.necessary, field.test);
  generatedField.divContent.classList.add('div_password');
  
  generatedField.input.classList.add('input_password');
  generatedField.input.addEventListener("change", UpdateInput);
  
  generatedField.label.classList.add('label_password');
  return generatedField.divContent;
}
function GenerateRadio(field){
  let generatedField = GenerateFieldInputWithLabel('radio', field.necessary, field.test);
  generatedField.divContent.classList.add('div_radio');
  
  generatedField.input.classList.add('input_radio');
  generatedField.input.value = field.value;
  generatedField.input.addEventListener("change", UpdateInput);
  
  generatedField.label.classList.add('label_radio');
  return generatedField.divContent;
}
function GenerateCheckbox(field){
  let generatedField = GenerateFieldInputWithLabel('checkbox', field.necessary, field.test);
  generatedField.divContent.classList.add('div_checkbox');
  
  generatedField.input.classList.add('input_checkbox');
  generatedField.input.value = field.value;
  generatedField.input.addEventListener("change", UpdateInput);
  
  generatedField.label.classList.add('label_checkbox');
  return generatedField.divContent;
}
function GenerateText(field){
  let generatedField = GenerateFieldInputWithLabel('text', field.necessary, field.test);
  generatedField.divContent.classList.add('div_text');
  
  generatedField.input.classList.add('input_text');
  generatedField.input.addEventListener("change", UpdateInput);
  
  generatedField.label.classList.add('label_text');
  return generatedField.divContent;
}
function GenerateTextArea(field){
  let divContent = document.createElement("div");
  divContent.classList.add('div_textarea');
  let input = document.createElement("textarea");
  input.classList.add('input_textarea');
  input.name = field.name;
  input.addEventListener("onchange", UpdateInput);
  
  if(field.necessary == true) input.required  = true;
  let info = GenerateInfo(field);
  info.classList.add('label_textarea');
  divContent.appendChild(info);
  divContent.appendChild(input);
  
  return divContent;
}
function GenerateFieldInputWithLabel(fieldType, isRequiered, pattern){
  let divContent = document.createElement("div");
  let input = document.createElement("input");
  input.type = fieldType;
  input.name = field.name;
  if(pattern) input.pattern = pattern;
  if(isRequiered) input.required  = true;
  let info = GenerateInfo(field);
  divContent.appendChild(info);
  divContent.appendChild(input);
  return {divContent, input, label:info};
}
function UpdateInput(e){
  ShowFields();
}
function ShowFields(){
  for(f of fieldsData){
    ShowField(f);
  }
}
function ShowField(f){
  let formData = new FormData(document.forms[0]);
  let inputField = f.inputField;
  let ifField = inputField.if; //undefined
  let generatedField = f.generatedField;
  if(ifField){ //if ifField != undefined
    let isActiveResult = GetIsActive(formData, ifField);
    SetActiveElement(inputField.name, generatedField, isActiveResult);
  }
}
function GetIsActive(formData, ifField){
let isActive = GetIsActiveData(formData, ifField);
  let isActiveResult = true;
  for(isActiveValue of isActive){
    if(!isActiveValue){
      isActiveResult = false;
      break;
    }
  }
  return isActiveResult;
}
function GetIsActiveData(formData, ifField){
  let isActive = [];
  for(prop of Object.keys(ifField)){
    let isFoundProp = false; 
    if(formData.has(prop)){
      for(value of formData.getAll(prop)){
        if(ifField[prop] == value){
          isFoundProp = true;
          break;
        }
      }
    }
    isActive.push(isFoundProp);
  }
  return isActive;
}
function SetActiveElement(fieldName, element, isActive){
  let formField = document.forms[0][fieldName];
  if(!isActive){
    formField.disabled = true;
    element.classList.add('input_hiden');
  }
  else{
    formField.disabled = false;
    element.classList.remove('input_hiden');
  }
}
function DeleteOutput(){
  let divOutput = document.getElementById("output_form");
  while (divOutput.firstChild) {
    divOutput.removeChild(divOutput.lastChild);
  }
}