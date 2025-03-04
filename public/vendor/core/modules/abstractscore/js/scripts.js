document.addEventListener("DOMContentLoaded", function(e) {
const categories = document.querySelector("#a3-category")
let checkboxReviewItem = document.querySelectorAll("input[name=reviewer]")
checkboxReviewItem.forEach(function(item){
    console.log(item);
    
    item.onclick = function(e){
        console.log(e.target.value);
        
    }
})

})
