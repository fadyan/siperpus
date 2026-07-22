<!-- Tombol Floating -->
<button id="aiButton">
    <i class="bi bi-robot"></i>
</button>

<!-- AI PANEL -->
<div id="aiPanel">

    <!-- Sidebar -->
    <!-- <div class="ai-sidebar">

        <button class="ai-new-chat">
            <i class="bi bi-plus-lg"></i>
            Chat Baru
        </button>

        <div class="ai-history">

            <div class="ai-history-item">
                <i class="bi bi-chat-left-text"></i>
                Selamat Datang
            </div>

            <div class="ai-history-item">
                <i class="bi bi-chat-left-text"></i>
                Cara Meminjam Buku
            </div>

            <div class="ai-history-item">
                <i class="bi bi-chat-left-text"></i>
                Buku Informatika
            </div>

        </div>

    </div> -->


    <!-- Content -->
    <div class="ai-content">

        <div class="ai-header">

            <span>

                <i class="bi bi-stars"></i>

                AI Assistant Perpustakaan

            </span>

            <button id="closeAI">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <div class="ai-body" id="chatBody">

            <div class="ai-message">

                <strong>Halo 👋</strong>

                <br><br>

                Saya adalah AI Assistant Perpustakaan.

                <br><br>

                Saya dapat membantu Anda mencari buku,
                menjelaskan prosedur peminjaman,
                maupun menjawab pertanyaan seputar perpustakaan.

            </div>

        </div>


        <div class="ai-footer">

            <div class="ai-input-group">

                <input
                    type="text"
                    id="prompt"
                    class="form-control"
                    placeholder="Tanyakan sesuatu...">

                <button
                    id="sendAI"
                    class="btn btn-primary">

                    <i class="bi bi-send-fill"></i>

                </button>

            </div>

        </div>

    </div>

</div> 

<script>
    $(function(){

    $("#aiButton").click(function(){
        

        $("#aiPanel").addClass("show");

        $("#aiButton").addClass("hide");

    });

    $("#closeAI").click(function(){

        $("#aiPanel").removeClass("show");

        $("#aiButton").removeClass("hide");


    });

    $("#openAI").click(function(e){

    e.preventDefault();

    $("#aiPanel").addClass("show");

    $("#aiButton").addClass("hide");

});


    $("#sendAI").click(function(){

        kirimPesan();

    });


    $("#prompt").keypress(function(e){

        if(e.which==13){

            kirimPesan();

        }

    });


    function kirimPesan(){

        let pesan = $("#prompt").val().trim();

        if(pesan=="") return;

        // Pesan User
        $("#chatBody").append(`
            <div class="chat-row user">
                <div class="chat-bubble">
                    ${pesan}
                </div>
            </div>
        `);

        $("#prompt").val("");

        // Auto Scroll
        $("#chatBody").scrollTop($("#chatBody")[0].scrollHeight);

        const loadingId = "typing-" + Date.now();

        // Loading AI
        $("#chatBody").append(`
            <div class="chat-row ai" id="${loadingId}">

                <div class="chat-avatar">
                    <i class="bi bi-robot"></i>
                </div>

                <div class="chat-bubble">
                    <div class="typing">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

            </div>
        `);

        $("#chatBody").scrollTop($("#chatBody")[0].scrollHeight);

        fetch('/chat',{

            method:'POST',

            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,
            },

            body:JSON.stringify({
                message:pesan
            })

        })

        .then(async(res)=>{

            const data = await res.json();

            if(!res.ok){
                throw new Error(data.message || "Terjadi kesalahan");
            }

            $("#" + loadingId).html(`
                <div class="chat-avatar">
                    <i class="bi bi-robot"></i>
                </div>

                <div class="chat-bubble">
                    ${data.answer}
                </div>
            `);

            $("#chatBody").scrollTop($("#chatBody")[0].scrollHeight);

        })

        .catch((err)=>{

            $("#" + loadingId).html(`
                <div class="chat-avatar">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

                <div class="chat-bubble">
                    ${err.message}
                </div>
            `);

            $("#chatBody").scrollTop($("#chatBody")[0].scrollHeight);

            console.error(err);

        });

    }

});
</script>