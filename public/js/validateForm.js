let clickedOnce = false;

async function validateUserName(e, username, formId) {

    let status = false;

    if (clickedOnce) {
        clickedOnce = false;
        status = false;
        return;
    } else {
        const FormEl = $("#" + formId);
        const userName = $("#username").val();

        let data = await axios.post(route("username.exists"), {
            data: { username: userName }
        });

        let userNameOk = await data.data;

        if (userNameOk == "no") {
            clickedOnce = true;
            status = true;
            FormEl.submit();
        } else {
            alert("User name already exists");
            status = false;
        }
    }

    return status;
}
