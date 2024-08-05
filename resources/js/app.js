// In resources/js/app.js or equivalent
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

import.meta.glob(['../images/**']);
document.addEventListener("DOMContentLoaded", function () {
    const alertMessage = document.getElementById('alertMessage');
    const alertbox = document.querySelector("#alertBox");
    function removeAlert() {
        if (alertbox) {
            setTimeout(() => {
                alertbox.classList.remove("show"); // Removes the show class to initiate fade out
                alertbox.classList.add("fade"); // Adds fade class to use Bootstrap's fade transition

                // Listen for the transition end event to remove the element from the DOM
                alertbox.addEventListener('transitionend', () => {
                    alertbox.style.display = 'none'; // Hide the element after fade out
                }, { once: true }); // { once: true } ensures the event listener is removed after it runs once
            }, 3000); // Adjust time as needed
        }
    }

    // Call removeAlert after setting the alert box
    function showAlert(message, isSuccess) {
        alertMessage.textContent = message;
        alertbox.classList.remove('fade');
        alertbox.style.display = 'block';
        alertbox.classList.add('show');

        if (isSuccess) {
            alertbox.classList.remove('alert-danger');
            alertbox.classList.add('alert-success');
        } else {
            alertbox.classList.remove('alert-success');
            alertbox.classList.add('alert-danger');
        }

        removeAlert(); // Call to start hiding the alert box after some time
    }
    const loginForm = document.querySelector("#loginForm");
    if (loginForm) {
        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault(); // Prevent the default form submission

            const form = e.target;
            const formData = new FormData(form); // Create a FormData object from the form

            const alertBox = document.getElementById('alertBox');
            const alertMessage = document.getElementById('alertMessage');

            try {
                const formobj = Object.fromEntries(formData.entries());
                const response = await fetch('login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Laravel CSRF token
                    },
                    body: JSON.stringify(formobj)
                });

                const data = await response.json();

                if (response.ok) {
                    // Display success message
                    alertMessage.textContent = data.success;
                    alertBox.classList.remove('fade');
                    alertBox.style.display = 'block';
                    alertBox.classList.add('show'); // Bootstrap class for visible alert

                    // Redirect to the dashboard after a short delay
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 3000); // Adjust delay as needed
                } else {
                    // Display error message
                    alertMessage.textContent = data.error || 'Login failed. Please check your credentials.';
                    alertBox.classList.remove('alert-success');
                    alertBox.classList.add('alert-danger');
                    alertBox.classList.remove('fade');
                    alertBox.style.display = 'block';
                    alertBox.classList.add('show');
                }
            } catch (error) {
                console.error('Error:', error);
                alertMessage.textContent = 'An error occurred. Please try again later.';
                alertBox.classList.remove('alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.classList.remove('fade');
                alertBox.style.display = 'block';
                alertBox.classList.add('show');
            }
        });
    }

    //leave rquest form
    const leaveForm = document.getElementById("leaveform");
    async function submitLeaveRequest(theform) {
        const reqForm = new FormData(theform);
        const formobj = Object.fromEntries(reqForm.entries());
        try {
            const response = await fetch(`/leave/request`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CRSF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formobj)
            })

            if (!response.ok) {
                throw new Error('Error posting request');
            }
            const data = await response.json();
            if (data.success) {
                showAlert(data.message, true);
                setTimeout(() => { location.reload(); }, 3000);
            } else {
                if (data.errors) {
                    let errorMessages = Object.values(data.errors).flat();
                    showAlert(errorMessages.join('<br>'), false);
                } else {
                    showAlert(data.message, false);
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('An error occurred. Please try again later.', false);

        }
    }
   /* if (leaveForm) {
        leaveForm.addEventListener("submit", function (e) {
            e.preventDefault();
            submitLeaveRequest(leaveForm);
        })
    } */
   //process payment for all
   if( document.getElementById('select-all')){
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.getElementsByName('payroll_ids[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    }
    //password form
    const passwordForm = document.getElementById("passwordform");
    async function changePassword(e) {
        e.preventDefault();
        const formdata = new FormData(passwordForm);
        const formobj = Object.fromEntries(formdata.entries());
        const userid = document.getElementById("userid")

        try {
            let id = userid.value;
            const response = await fetch(`/dashboardprofile/${id}/changepassword`, {
                'method': 'POST',
                headers: {

                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formobj)
            })

            if (!response.ok) {
                throw new Error('Error fetching data');
            }
            const data = await response.json();
            if (data.success) {
                showAlert(data.message, true);
                setTimeout(() => { location.reload(); }, 3000);
            } else {
                if (data.errors) {
                    let errorMessages = Object.values(data.errors).flat();
                    showAlert(errorMessages.join('<br>'), false);
                } else {
                    showAlert(data.message, false);
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('An error occurred. Please try again later.', false);
        }
    }
    if (passwordForm) {
        passwordForm.addEventListener("submit", changePassword);
    }
    const checkinForm = document.getElementById("checkinForm");
    if (checkinForm) {
        checkinForm.addEventListener('submit', function (event) {
            // Disable the submit button
            event.target.querySelector('button[type="submit"]').disabled = true;
        });
    }

    function updateClock() {
        // Get the current time
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');

        // Format the time as a string
        const currentTime = `${hours}:${minutes}:${seconds}`;

        // Update the clock element with the current time
        document.getElementById('clock').textContent = currentTime;
    }

    // Update the clock immediately when the page loads
    updateClock();

    // Update the clock every second
    setInterval(updateClock, 1000);

    const dashboardform = document.querySelector("#filterSelect");
    const workercount = document.getElementById("workercount");
    const workertype = document.getElementById("workertype");
    const percentageChange = document.getElementById("percentageChange");
    if (dashboardform) {
        dashboardform.addEventListener("change", async (e) => {
            const selectvalue = dashboardform.value
            e.preventDefault();
            try {
                const response = await fetch(`/dashboard/count?filter=${selectvalue}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                })

                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }

                const data = await response.json();

                if (data.success) {
                    workercount.innerHTML = data.workerscount;
                    workertype.innerHTML = data.workertype;
                    percentageChange.innerHTML = data.percentageChange.toFixed(2) + '%';
                } else {
                    workercount.innerHTML = "";
                    workertype.innerHTML = "All"
                    percentageChange.innerHTML = ""
                }

            } catch (e) {
                console.error(e);
            }
        })
    }
    async function updateDashboard(e) {
        try {
            const response = await fetch(`/dashboard/count?filter=${'all'}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })

            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }

            const data = await response.json();

            if (data.success) {
                workercount.innerHTML = data.workerscount;
                workertype.innerHTML = data.workertype;

            } else {
                workercount.innerHTML = "";
                workertype.innerHTML = "All"
                percentageChange.innerHTML = ""
            }

        } catch (e) {
            console.error(e);
        }
    }



    const workertypepresent = document.getElementById("workertypepresent");
    const workercountpresent = document.getElementById("workercountpresent");
    const workercountabsent = document.getElementById("workercountabsent");
    const workercountlate = document.getElementById("workercountlate");
    const workercountleave = document.getElementById("workercountleave");
    const presentForm = document.getElementById("filterPresent");
    const presentWorkers = async () => {
        const choice = presentForm.value
        try {
            const response = await fetch(`dashboard/countpresent/?filter=${choice}`, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })

            if (!response.ok) {
                throw new error("error fetching data")
            }
            const data = await response.json();
            if (data.success) {
                workercountpresent.innerHTML = data.presentcount + data.latecount
                workercountabsent.innerHTML = data.absentcount
                workercountleave.innerHTML = data.leavecount
                workercountlate.innerHTML = data.latecount
                workertypepresent.innerHTML = data.workertype
            } else {
                workercountpresent.innerHTML = ""
                workertypepresent.innerHTML = "All"
            }
        } catch (error) {
            console.error(error)
        }
    }




    const activeWorkerSelect = document.getElementById("filterworkersactive");
    const suspendedWorkerSelect = document.getElementById("filterworkersuspended");
    const workeractiveCount = document.getElementById("workeractivecount")
    const workerSuspendedCount = document.getElementById("workersuspendedcount")
    const workeractivetype = document.querySelector(".workeractivetype");
    const workersuspendedtype = document.querySelector(".workersuspendedtype");

    async function getActiveWorkers(selectgroup) {
        const choice = selectgroup.value
        try {
            const response = await fetch(`dashboard/activeworker/?filter=${choice}`, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            if (!response.ok) {
                throw new Error("Error fetching data")
            }
            const data = await response.json();
            if (data.success) {
                workeractiveCount.innerHTML = data.activecount
                workerSuspendedCount.innerHTML = data.suspendedcount
                workeractivetype.innerHTML = data.workertype
                workersuspendedtype.innerHTML = data.workertype
            } else {
                workeractiveCount.innerHTML = ""
                workerSuspendedCount.innerHTML = ""
                workeractivetype.innerHTML = "All"
                workersuspendedtype.innerHTML = "All"
            }
        } catch (error) {
            console.error(error)
        }
    }


    const departmentheadcount = document.getElementById("departmentheadcount");
    const departmentTotalCount = document.getElementById("departmenttotalcount");

    async function getDepartmentCount() {

        try {
            const response = await fetch(`dashboard/departmentcount/`, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            if (!response.ok) {
                throw new Error("error fetching department data");
            }

            const data = await response.json();
            if (data.success) {
                departmentheadcount.innerHTML = data.headcount;
                departmentTotalCount.innerHTML = data.departmentcount;

            } else {
                departmentheadcount.innerHTML = "";
                departmentType.innerHTML = "All";
                departmentTotalCount = "";
            }
        } catch (error) {
            console.error(error);
        }
    }



    const activeDepartmentSelect = document.getElementById("filterSelectDepartmentActive")
    const suspendedDepartmentSelect = document.getElementById("filterSelectDepartmentSuspended")
    const departmentactivetype = document.getElementById("departmentactivetype")
    const departmentactivecount = document.getElementById("departmentactivecount")
    const departmentsuspendedcount = document.getElementById("departmentsuspendedcount")
    const departmentactiveheadcount = document.getElementById("departmentactiveheadcount")
    const departmenthead = document.getElementById("departmenthead")

    async function getDepartmentActiveCount(selectgroup) {
        const choice = selectgroup.value
        try {
            const response = await fetch(`dashboard/departmentactivecount/?filter=${choice}`, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            if (!response.ok) {
                throw new Error("error fetching department data");
            }

            const data = await response.json();
            if (data.success) {
                departmentactiveheadcount.innerHTML = data.activeheadcount;
                departmentsuspendedcount.innerHTML = data.suspendedcount;
                departmentactivecount.innerHTML = data.activecount;
                departmenthead.innerHTML = data.departmenthead[0]['firstname'] + " " + data.departmenthead[0]['lastname'];
                departmentactivetype.innerHTML = data.departmenttype

            } else {
                departmentactiveheadcount.innerHTML = "";
                departmentsuspendedcount.innerHTML = "";
                departmentactivecount.innerHTML = "";
                departmenthead.innerHTML = "President";
                departmentactivetype.innerHTML = "All"
            }
        } catch (error) {
            console.error(error);
        }
    }


    if (window.location.href.endsWith("dashboard")) {
        updateDashboard();
        presentWorkers();
        getActiveWorkers(activeWorkerSelect)
        getDepartmentCount();
        //getActiveWorkers(suspendedWorkerSelect)
        activeWorkerSelect.addEventListener("change", function () {
            getActiveWorkers(activeWorkerSelect);
        });
        suspendedWorkerSelect.addEventListener("change", function () {
            getActiveWorkers(suspendedWorkerSelect);
        });

        getDepartmentActiveCount(activeDepartmentSelect);

        activeDepartmentSelect.addEventListener("change", function () {
            getDepartmentActiveCount(activeDepartmentSelect);
        })
        presentForm.addEventListener("change", presentWorkers);
    }


})
