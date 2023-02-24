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
                            $("#success-title").html("カード削除完了");
                            $("#success-body").html("カードを削除しました。");
                            $("#modal-success .card-image").attr("src", "/user/images/" + type + ".png");
                            $("#modal-success .card-number").html(data.card_number);
                            $("#modal-success").modal("show");
                            $("#modal-success").on(
                                "hidden.bs.modal",
                                function() {
                                    window.location.replace("/card-management");
                                }
                            );
                        }  else {
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
                                    window.location.replace("/service/payment");
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

    $("#username").keyup(function() {
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

    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
    
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
        if ($("#save-card").is(":checked")) {
            addCard(e);
        } else {
            submitToken(e);
        }
    });
    var card_id = null;

    $(".remove-card").on("click", function(e) {
        card_id = $(e.currentTarget).attr("data-value");
        let def = $(e.currentTarget).attr("data-default");

        if (def && def != 0) {
            $("#notify-modal img").attr("src", "/user/images/icon-x_fill.png");
            $("#notify-modal #notify-title").html("デフォルトカードです！");
            $("#notify-modal .notify-body").html(
                "月額払いに使用されているデフォルトカードです。デフォルトカードを変更してから削除してください。"
            );
            $("#notify-modal").modal("show");
        } else {
            $("#confirm_modal img").attr("src", "/user/images/icon-x_fill.png");
            $("#confirm_modal .notification-title").html("カード削除");
            $("#confirm_modal .notification-body").html(
                "カードを本当に削除してよろしいでしょうか？"
            );
            $("#action").addClass("remove");
            $("#confirm_modal").modal("show");
        }
    });

    $(document).on("click", ".remove", function(e) {
        let data = {
            card_id: card_id,
            account_id: document.getElementById("account_id").value,
        };
        deleteCard(data);
    });

    function deleteCard(data) {
        $("body").addClass("load");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/card-management/delete",
            type: "post",
            data: data,
            success: function(response) {
                $("body").removeClass("load");
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function(e) {
                $("body").removeClass("load");
            },
        });
    }
    $(".show-default").on("click", function(e) {
        $("#change-default").modal("show");
    });
    $("#add-card").on("click", function(e) {
        e.preventDefault();
        $("#add_new_card").modal("show");
    });
    $("#add-new-card").on("click", function(e) {
        addCard(e);
    });
    $("#complete").on("click", function(e) {});
    $('input:radio[name="card"]').on("change", function(e) {
        let number = $(e).attr("data-number");
        let expire = $(e).attr("data-expire");
        $("#card_expire").val(expire);
        $("#card_no").val(number);
        card_id = e.target.value;
    });

    $("#accept").on("change", function(e) {
        if ($("#accept").is(":checked")) {
            $("#confirm").removeAttr("disabled");
        } else {
            $("#confirm").prop("disabled", "disabled");
        }
        if ($("#accept").is(":checked")) {
            $("#complete").removeAttr("disabled");
        } else {
            $("#complete").prop("disabled", "disabled");
        }
    });

    $('.back').on('click', function(e) {
        e.preventDefault();
        window.history.back();
    })
    
    // $("#confirm").on("click", function(e) {
    //     e.preventDefault();
    //     $order_id = $("#order-id").val();
    //     if ($order_id) {
    //         $('form').submit();
    //         // window.location.replace("/service/payment/" + $order_id);
    //     } else {
    //         window.location.replace("/service/payment/");
    //     }
    // });

    $("#change-pay-card").on("click", function(e) {
        e.preventDefault();
        let data = {
            card_id: card_id ? card_id : $('input:radio[name="card"]').val(),
            account_id: document.getElementById("account_id").value,
        };
        $("body").addClass("load");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/card-management/default",
            type: "post",
            data: data,
            success: function(response) {
                $("body").removeClass("load");
                $("#success-title").modal("デフォルトカードを設定しました。");
                $("#form-order").submit();
            },
            error: function(e) {
                $("body").removeClass("load");
            },
        });
    });
    $("#postpaid-accept").on("change", function(e) {
        if ($("#postpaid-accept").is(":checked")) {
            $("#postpaid-confirm").removeAttr("disabled");
        } else {
            $("#postpaid-confirm").prop("disabled", "disabled");
        }
    });
    $('#payment-method').on('change', function(e) {
        if (e.target.value == 2) {
            if (sessionStorage.getItem('#postpaid_privacy') !== 'true') {
                $('#postpaid_privacy').modal('show');
            } else {
                $('#method').val(2);
                $("#postpaid-noty").show()
            }
        } else {
            $('#method').val(1);
            $("#postpaid-noty").hide()
        }
    })
    $("#postpaid-confirm").on("click", function(e) {
        sessionStorage.setItem('#postpaid_privacy', 'true');
        $('#method').val(2);
        $("#postpaid-noty").show()
    });
    $('#postpaid_privacy').on('hidden.bs.modal', function () {
        if (sessionStorage.getItem('#postpaid_privacy') !== 'true') {
            $('#payment-method').val(1);
            $('#method').val(1);
            $("#postpaid-noty").hide()
        }
    });
})();