<?php
// Query untuk mengambil data milik pengguna yang sedang login
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>

<div class="rekomendasi-shoes">
    <div class="container d-flex justify-content-center">
        <div class="container-rec rounded">
            <div class="bg-second rounded-top py-2 px-5 fw-bold fs-5">
                Rekomendasi Sepatu Sepak Bola
            </div>
            <div class="d-flex flex-column alignt-items-center justify-content-center rounded-bottom p-3 gap-3">
                <button data-toggle="modal" data-target="#chatModal" onclick="bukaQuest()"
                    class="p-2 bg-prime rounded d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-regular fa-comment-dots fs-5"></i> Pilih Preferensi
                </button>
                <a href="index.php?page=home"
                    class="p-2 bg-prime rounded d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i>Cari Sepatu
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-second">
                <h5 class="modal-title" id="chatModalLabel">Chatbot Sepatu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="chatbotForm" method="POST" action="../admin/aksi/tambah.php">
                    <div id="question-container">
                        <!-- Pertanyaan dan pilihan jawaban akan dimuat di sini -->
                    </div>
                    <input type="hidden" name="action" value="add_user_recommendation">
                    <input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
                    <input type="hidden" name="position" id="position">
                    <input type="hidden" name="surface" id="surface">
                    <input type="hidden" name="brand" id="brand">
                    <input type="hidden" name="material" id="material">
                    <input type="hidden" name="color" id="color">
                    <input type="hidden" name="series" id="series">
                    <input type="hidden" name="price" id="price">
                    <input type="hidden" name="prioritas" id="prioritas">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Modal dan Logika Chatbot -->
<script>
    // Data pertanyaan dan jawaban beserta value-nya
    const questions = [{
            question: "Posisi Anda di Lapangan?",
            answers: [{
                    text: "Penyerang",
                    value: "Striker"
                },
                {
                    text: "Gelandang",
                    value: "Midfielder"
                },
                {
                    text: "Bek",
                    value: "Defender"
                },
                {
                    text: "Kiper",
                    value: "Goalkeeper"
                },
                {
                    text: "Winger",
                    value: "Winger"
                }
            ],
        },
        {
            question: "Di Lapangan Apa Anda Bermain?",
            answers: [{
                    text: "Rumput alami",
                    value: "FG"
                },
                {
                    text: "permukaan berlumpur atau basah",
                    value: "SG"
                },
                {
                    text: "Rumput Buatan",
                    value: "AG"
                },
                {
                    text: "Tidak ada Preferensi",
                    value: "FG"
                }
            ]
        },
        {
            question: "Apakah Anda Mencari Sepatu dengan Merek Tertentu?",
            answers: ["Specs", "Mills", "Ortuseight"]
        },
        {
            question: "Material Sepatu Apa yang Anda Lebih Sukai? ",
            answers: [{
                    text: "Terbuat dari bahan rajutan",
                    value: "Knit"
                },
                {
                    text: "Sintetis(Material buatan manusia)",
                    value: "Synthetic"
                },
                {
                    text: "Terbuat dari kulit alami",
                    value: "Leather"
                },
            ]
        },
        {
            question: "Apa warna yang anda suka?",
            answers: [{
                    text: "Putih",
                    value: "putih"
                },{
                    text: "Merah",
                    value: "merah"
                },
                {
                    text: "Hitam",
                    value: "hitam"
                },
                {
                    text: "Hijau",
                    value: "hijau"
                },
                {
                    text: "Silver",
                    value: "silver"
                },
                {
                    text: "Kuning",
                    value: "kuning"
                },
                {
                    text: "Biru",
                    value: "biru"
                },
                {
                    text: "Ungu",
                    value: "ungu"
                },
                {
                    text: "Oren",
                    value: "oren"
                },
                {
                    text: "Merah muda",
                    value: "merah muda"
                },
                {
                    text: "Emas",
                    value: "emas"
                },
            ]
        },
        {
            question: "Apa yang Anda Lebih Utamakan?",
            answers: [{
                    text: "Kecepatan",
                    value: "kecepatan"
                },
                {
                    text: "Kontrol bola",
                    value: "kontrol"
                },
                {
                    text: "Flesibilitas",
                    value: "fleksibel"
                },
                {
                    text: "Kecepatan dan ringan",
                    value: "ringan"
                },
            ]
        },
        {
            question: "Brapa Budget ynag Anda Miliki?",
            answers: [{
                    text: "Kurang Dari Rp. 500.000",
                   value: "{max:500000}"
                },
                {
                    text: "lebih Dari Rp. 500.000",
                    value: "{min:500000}"
                },
            ]
        },
        {
            question: "Apa yang paling Anda utamakan dalam sepatu bola?",
            answers: [{
                    text: "Merk Sepatu",
                    value: "brand_similarity"
                },
                {
                    text: "Fungsi Sepatu",
                    value: "series_similarity"
                },
                {
                    text: "Bahan(Material) Sepatu",
                    value: "material_similarity"
                },
                {
                    text: "Warna sepatu",
                    value: "color_similarity"
                },
                {
                    text: "Sepatu untuk posisi tertentu",
                    value: "position_similarity"
                },
                {
                    text: "Sepatu untuk lapangan tertentu",
                    value: "surface_similarity"
                },
            ]
        },
    ];

    let currentQuestionIndex = 0;

    const questionContainer = document.getElementById("question-container");
    const chatbotForm = document.getElementById("chatbotForm");

    // Fungsi untuk menampilkan pertanyaan dan pilihan jawaban
    function showQuestion() {
        const question = questions[currentQuestionIndex];

        // Jika question.answers adalah array objek (untuk yang memiliki value khusus)
        if (typeof question.answers[0] === 'object') {
            questionContainer.innerHTML = `
            <div class="mb-3">${question.question}</div>
            <div class="d-flex flex-column">
                ${question.answers.map(answer => `
                    <button type="button" class="btn btn-second btn-block option-btn mb-2" onclick="handleAnswer('${answer.value}')">${answer.text}</button>
                `).join('')}
                </div>
            `;
        } else {
            // Jika jawaban hanya berupa array teks
            questionContainer.innerHTML = `
                <div class="mb-3">${question.question}</div>
                <div class="d-flex flex-column">
                ${question.answers.map(answer => `
                    <button type="button" class="btn btn-second btn-block option-btn mb-2" onclick="handleAnswer('${answer}')">${answer}</button>
                `).join('')}
                </div>
            `;
        }
    }

    // Fungsi untuk menangani jawaban yang dipilih
    function handleAnswer(answer) {
        // Menyimpan jawaban ke input hidden sesuai pertanyaan
        if (currentQuestionIndex === 0) {
            document.getElementById("position").value = answer;
        } else if (currentQuestionIndex === 1) {
            document.getElementById("surface").value = answer; 
        } else if (currentQuestionIndex === 2) {
            document.getElementById("brand").value = answer;
        } else if (currentQuestionIndex === 3) {
            document.getElementById("material").value = answer;
        } else if (currentQuestionIndex === 4) {
            document.getElementById("color").value = answer;
        } else if (currentQuestionIndex === 5) {
            document.getElementById("series").value = answer;
        }else if (currentQuestionIndex === 6) {
            document.getElementById("price").value = answer;
        }else if (currentQuestionIndex === 7) {
            document.getElementById("prioritas").value = answer;

            chatbotForm.submit();
            return; 
        }

        // Lanjutkan ke pertanyaan berikutnya
        currentQuestionIndex++;

        if (currentQuestionIndex < questions.length) {
            showQuestion();
        }
    }

    function bukaQuest() {
        currentQuestionIndex = 0; // Reset ke pertanyaan pertama setiap kali dibuka
        showQuestion();
    }
</script>

<!-- Bootstrap JS dan jQuery (via CDN) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>