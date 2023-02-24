(function() {
    function GetCardType(number) {
        // visa
        var re = new RegExp("^4");
        if (number.match(re) != null)
            return "visa";

        // Mastercard 
        // Updated for Mastercard 2017 BINs expansion
        let mastercard = new RegExp('^5[1-5]*');
        let mastercard2 = new RegExp('^2[2-7]*');
        
        if (number.match(mastercard) != null || number.match(mastercard2))
            return "master";

        // AMEX
        re = new RegExp("^3[47]");
        if (number.match(re) != null)
            return "amex";

        // Diners
        re = new RegExp("^36");
        if (number.match(re) != null)
            return "diner";

        // Diners - Carte Blanche
        re = new RegExp("^30[0-5]");
        if (number.match(re) != null)
            return "diner";

        // JCB
        re = new RegExp("^35(2[89]|[3-8][0-9])");
        if (number.match(re) != null)
            return "jbc";

        re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
        if (number.match(re) != null)
            return "visa";

        return "";
    }

    function submitToken(e) {
        var data = {};
        data.token_api_key = document.getElementById("token_api_key").innerText;
        if (document.getElementById("card_number")) {
            data.card_number = document.getElementById("card_number").value.replaceAll(/\s/g, '');
        }
        if (document.getElementById("cc-exp")) {
            data.card_expire = document.getElementById("cc-exp").value;
        }
        if (document.getElementById("cc-csc")) {
            data.security_code = document.getElementById("cc-csc").value;
        }
        if (document.getElementById("username")) {
            let username = document.getElementById("username").value;
            if (username.trim() == '' || !/^[a-zA-Z\s]*$/.test(username)) {
                $("#notify-modal #notify-title").html(
                    "カード保有者名のフォーマットが異常です。"
                );
                $("#notify-modal").modal("show");
                return
            }
        }
        data.lang = "ja";

        var url = document.getElementById("token_api_url").innerText;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("Content-Type", "application/json; charset=utf-8");
        $('body').addClass('load');
        xhr.addEventListener("loadend", function() {
            if (xhr.status === 0) {
                alert("トークンサーバーとの接続に失敗しました");
                return;
            }
            var response = JSON.parse(xhr.response);
            if (xhr.status == 200) {
                document.getElementById("cc-csc").value = "";
                document.getElementById("token").value = response.token;
                document.getElementById("req_card_number").value = response.req_card_number;
                document.forms[0].submit();
            } else {
                $('body').removeClass('load');
                $("#notify-modal #notify-title").html(
                    response.message
                );
                // $("#notify-modal #notify-body").html(
                //     response.message
                // );
                $("#notify-modal").modal("show");
            }
        });
        xhr.send(JSON.stringify(data));
    }

    function addCard(e) {
        var data = {};
        data.token_api_key = document.getElementById("token_api_key").innerText;
        if (document.getElementById("card_number")) {
            data.card_number = document
                .getElementById("card_number")
                .value.replaceAll(/\s/g, "");
        }
        if (document.getElementById("cc-exp")) {
            data.card_expire = document.getElementById("cc-exp").value;
        }
        if (document.getElementById("cc-csc")) {
            data.security_code = document.getElementById("cc-csc").value;
        }
        if (document.getElementById("username")) {
            let username = document.getElementById("username").value;
            if (username.trim() == "" || !/^[a-zA-Z\s]*$/.test(username)) {
                $("#notify-modal #notify-title").html(
                    "カード保有者名のフォーマットが異常です。"
                );
                $("#notify-modal").modal("show");
                return;
            }
        }
        data.lang = "ja";

        var url = document.getElementById("token_api_url").innerText;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("Content-Type", "application/json; charset=utf-8");
        $("body").addClass("load");
        xhr.addEventListener("loadend", function() {
            if (xhr.status === 0) {
                alert("トークンサーバーとの接続に失敗しました");
                return;
            }
            var response = JSON.parse(xhr.response);
            if (xhr.status == 200) {
                var remember = document.getElementById("default");
                let data = {
                    account_id: $("#account_id").val(),
                    token: response.token,
                    card_number: response.req_card_number,
                    default: remember ? remember.checked : false,
                };
                let type = GetCardType(response.req_card_number);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
                    },
                    url: "/card-management/add",
                    type: "post",
                    data: data,
                    success: function(response) {
                        $("body").removeClass("load");
                        if (response.success) {
                            $("#add_new_card").modal("hide");
                            $("#modal-success .card-image").attr("src", "/user/images/" + type + ".png");
                            $("#modal-success .card-number").html(data.card_number);
                            $("#modal-success").modal("show");
                            $("#modal-success").on(
                                "hidden.bs.modal",
                                function() {
                                    window.location.reload();
                                }
                            );
                        } else {
                            $("#notify-modal #notify-title").html(
                                response.mess
                            );
                            $("#notify-modal").modal("show");
                            $("#notify-modal").on(
                                "hidden.bs.modal",
                                function() {
                                    window.location.reload();
                                }
                            );
                        }
                    },
                    error: function(e) {
                        $("body").removeClass("load");
                    },
                });
            } else {
                $("body").removeClass("load");
                $("#notify-modal #notify-title").html(response.message);
                $("#notify-modal").modal("show");
            }
        });
        xhr.send(JSON.stringify(data));
    }

    const getCardNumberSectionCount = function(value) {
        if (/^\D*3[47]/.test(value)) {
            // American Express
            return [4, 6, 5];
        } else if (/^\D*3(?:0[0-5]|[68])/.test(value)) {
            // Diner's Club
            return [4, 6, 4];
        }

        // Any regular credit card number
        return [4, 4, 4, 4];
    };

    $('#username').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });

    let formatCreditCardInput = function(query) {
        const element = $(query);
        if (!element) return;
        let formatInput = function(input, char, backspace) {
            let start = 0;
            let end = 0;
            let pos = 0;
            let value = input.value;

            if (char !== false) {
                start = input.selectionStart;
                end = input.selectionEnd;

                if (backspace && start > 0) {
                    // handle backspace onkeydown
                    start--;

                    if (value[start] == " ") {
                        start--;
                    }
                }
                // To be able to replace the selection if there is one
                value = value.substring(0, start) + char + value.substring(end);

                pos = start + char.length; // caret position
            }

            let digitCount = 0; // digit count
            let totalCount = 0; // total
            let groupIndex = 0; // group index
            let newValue = "";
            let groups = getCardNumberSectionCount(input.value);

            for (let i = 0; i < value.length; i++) {
                if (/\D/.test(value[i])) {
                    if (start > i) {
                        pos--;
                    }
                } else {
                    if (digitCount === groups[groupIndex]) {
                        newValue += " ";
                        digitCount = 0;
                        groupIndex++;

                        if (start >= i) {
                            pos++;
                        }
                    }
                    newValue += value[i];
                    digitCount++;
                    totalCount++;
                }
                if (
                    digitCount === groups[groupIndex] &&
                    groups.length === groupIndex + 1
                ) {
                    // max length
                    break;
                }
            }
            input.value = newValue;

            if (char !== false) {
                input.setSelectionRange(pos, pos);
            }
        };

        /**
         * Event listener for keypress on card number input
         */
        element.keypress(function(e) {
            let code = e.charCode || e.keyCode || e.which;

            // Check for tab and arrow keys (needed in Firefox)
            if (
                code !== 9 &&
                (code < 37 || code > 40) &&
                // and CTRL+C / CTRL+V
                !(e.ctrlKey && (code === 99 || code === 118))
            ) {
                e.preventDefault();

                let char = String.fromCharCode(code);

                // if the character is non-digit
                // -> return false (the character is not inserted)

                if (/\D/.test(char)) {
                    return false;
                }

                formatInput(this, char);
            }
        });

        /**
         * Event listener for keydown on card number input
         */
        element.keydown(function(
            e // backspace doesn't fire the keypress event
        ) {
            if (e.keyCode === 8 || e.keyCode === 46) {
                // backspace or delete
                e.preventDefault();
                formatInput(
                    this,
                    "",
                    this.selectionStart === this.selectionEnd
                );
            }
        });

        /**
         * Event listener for paste on card number input
         */
        element.on("paste", function() {
            // A timeout is needed to get the new value pasted
            setTimeout(function() {
                formatInput(element[0], "");
            }, 50);
        });

        /**
         * Event listener for blur on card number input
         */
        element.on("blur keyup", function() {
            formatInput(this, false);
        });
    };

    const formatExpireDate = function(id) {
        const element = $(id);
        if (!element) return;

        element.keyup(function(event) {
            //var inputChar = String.fromCharCode(event.keyCode);
            var code = event.keyCode;
            var allowedKeys = [8];
            if (allowedKeys.indexOf(code) !== -1) {
                return;
            }

            event.target.value = event.target.value
                .replace(
                    /^([1-9]\/|[2-9])$/g,
                    "0$1/" // 3 -> 03/
                )
                .replace(
                    /^(0[1-9]|1[0-2])$/g,
                    "$1/" // 11 -> 11/
                )
                .replace(
                    /^([0-1])([3-9])$/g,
                    "0$1/$2" // 13 -> 01/3
                )
                .replace(
                    /^(0?[1-9]|1[0-2])([0-9]{2})$/g,
                    "$1/$2" // 141 -> 01/41
                )
                .replace(
                    /^([0]+\/?)/g,
                    "0" ////  /^([0]+)\/|[0]+$/g, '0' // 0/ -> 0
                )
                .replace(
                    /[^\d\/]|^[\/]*$/g,
                    "" // To allow only digits and `/`
                )
                .replace(
                    /^([1-9]\/\d+)$/g,
                    "0$1" // 3/234 -> 03/234
                )
                .replace(
                    /^(0[1-9]|1[0-2])(\d+)$/g,
                    "$1/$2" // 1234 -> 12/34
                )
                .replace(
                    /^(1[3-9]|[2-9])(\d+)$/g,
                    "0$1/$2" // 234 -> 02/34
                )
                .replace(
                    /\/\//g,
                    "/" // Prevent entering more than 1 `/`
                )
                .substr(0, 5);
        });
    };
    formatCreditCardInput("#card_number");
    formatExpireDate("#cc-exp");
    $("#pay").on("click", function(e) {
        // submitToken(e);
        if ($("#save-card").is(":checked")) {
            addCard(e);
        } else {
            submitToken(e);
        }
    });
})();