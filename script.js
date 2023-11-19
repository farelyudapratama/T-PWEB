function openModal() {
    // Fetch the data of the selected note using sno and populate the modal fields
    // Replace the following lines with your code to fetch data from the server
    var title = "Title"; // Replace with the actual title
    var desc = "Description"; // Replace with the actual description

    document.getElementById("editTitle").value = title;
    document.getElementById("editDesc").value = desc;

    // You might want to open the modal here
    document.getElementById("editModal").style.display = "block";
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

// Close the modal if the user clicks outside of it
window.onclick = function (event) {
    var modal = document.getElementById("editModal");
    if (event.target == modal) {
        closeModal();
    }
};



// 

const edit=document.querySelectorAll(".edit");
        const editTitle=document.getElementById("editTitle");
        const editDesc=document.getElementById("editDesc");
        const hiddenInput=document.getElementById("hidden");
        edit.forEach(element => {
            element.addEventListener("click", ()=>{
                const titleText=element.parentElement.children[0].innerText
                const descText=element.parentElement.children[1].innerText
                editTitle.value=titleText
                editDesc.value=descText
                hiddenInput.value=element.id
            })
        })

        function openModal() {
            document.getElementById("editModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }

        window.onclick = function (event) {
            var modal = document.getElementById("editModal");
            if (event.target == modal) {
                closeModal();
            }
        };