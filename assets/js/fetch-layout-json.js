// This script fetches the layout JSON from the REST API and copies it to the clipboard
document.addEventListener("DOMContentLoaded", function () {
  // Get the button element
  var getBricksLayoutJsonBtns = document.querySelectorAll(
    ".getBricksLayoutJsonBtn"
  ); // Ensure this ID matches your button

  // Check if the button exists
  if (getBricksLayoutJsonBtns) {
    getBricksLayoutJsonBtns.forEach(function (button) {
      // Add an event listener to the button
      button.addEventListener("click", async function () {
        var layoutId = button.dataset.layoutId;

        const url = bricksLayoutData.endpointUrl;
        const nonce = bricksLayoutData.nonce;

        const options = {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-WP-Nonce": nonce,
          },
          body: JSON.stringify({ post_id: layoutId }),
        }; // end options

        try {
          // fetch the data from the REST API
          const response = await fetch(url, options);
          // check if the response is ok
          if (!response.ok) {
            // if not, throw an error
            throw new Error(
              "Network response was not ok " + response.statusText
            );
          }
          // if it is ok, parse the response as JSON
          const data = await response.json();
          // stringify the JSON
          const jsonString = JSON.stringify(data);
          //optional if statement... this should be a popup that informs the user
          const copyText = navigator.clipboard.writeText(jsonString);

          // alert the user that the JSON has been copied to the clipboard
          if (copyText) {
            alert("copied json");
          } else {
            alert("failed to copy");
          }
        } catch (error) {
          // if there is an error, log it to the console
          console.error("Fetch error: ", error);
        } // end try/catch
      }); // end button event listener
    }); // end forEach on line 7
  } // end if on line 4
}); // end DOMContentLoaded event listener
