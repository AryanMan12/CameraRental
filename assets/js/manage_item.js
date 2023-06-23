
function toggleAddItem() {
    const divData = document.getElementById("addItem");
    const btnData = document.getElementById("add_btn");
    let displayData = window.getComputedStyle(divData).display;
    if (displayData == "none"){
        divData.style.display = 'flex';
        btnData.value = "Close Form"
    }else{
        divData.style.display = "none";
        btnData.value = "Add Item"
    }
}