function ConfirmDelete(message)
{
  return confirm(message);
}
CKEDITOR.replace('ckeditor');
CKEDITOR.replace('add_product_ckeditor');
CKEDITOR.replace('desc_product_ckeditor');

function stepper(id)
{
  let myInput = document.getElementById("input-number");
  let min = myInput.getAttribute("min");
  let value = myInput.getAttribute("value");
  let newValue = (id == "increment") ? parseInt(value) + 1 : parseInt(value) - 1;
 
  if(newValue >= min){
    myInput.setAttribute("value", newValue);
  }
}
