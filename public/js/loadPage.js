document.addEventListener("DOMContentLoaded", function (event) {
    // Your code to run since DOM is loaded and ready
    let links = document.querySelectorAll('.doc-link')
    // add on click listeners that retrieve a page
    for (const link in links) {
        if (Object.hasOwnProperty.call(links, link)) {
            const element = links[link];
            element.addEventListener('click', function(event) {
                console.log('clicked')
                event.preventDefault();
                clearActiveLinks()
                element.classList.add('active')
                
                let formData = new FormData()
                formData.append('document', element.hash.replace('#', ''))
                
                let xhttp = new XMLHttpRequest()
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText)
                        document.getElementById("content").innerHTML = this.responseText
                    }
                };
                xhttp.open("POST", "./index.php", true)
                xhttp.send(formData)
            })
        }
    }
})

function clearActiveLinks()
{
    document.querySelectorAll('.active').forEach(element => {
        element.classList.remove('active')
    })
}