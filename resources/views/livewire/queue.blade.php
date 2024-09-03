<div class="tw-w-screen tw-h-screen tw-bg-gradient-to-r tw-from-white tw-from-[4%] tw-via-[#9EFFE8] tw-via-[38%] tw-to-[#1DAFFF] tw-flex tw-flex-col"
    x-data="queue">
    <div class="tw-flex tw-justify-between tw-items-center tw-w-full tw-px-4">
        <img src="{{ $photo ? asset('storage/' . $photo) : 'https://picsum.photos/1920/1080' }}" alt=""
            class="tw-object-cover tw-object-center tw-w-[560px] tw-h-[160px]">
        <div class="tw-flex tw-items-end tw-flex-col">
            <p class="tw-text-4xl" id="time"></p>
            <p class="tw-text-2xl">{{ \Carbon\Carbon::now()->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}</p>
        </div>
    </div>
    <div class="tw-w-full grid grid-cols-2 gap-2 tw-flex-1 tw-flex">
        <div class="tw-w-full tw-p-6 tw-bg-gradient-to-b tw-from-[#341B72] tw-to-[#61DEFF]">
            <p class="tw-text-5xl tw-text-white text-center tw-font-black">Nomor Antrian</p>
            <div class="tw-py-16 tw-bg-white">
                <p class="tw-text-[100px] tw-text-[#001281] tw-text-center" x-text="queue_number"></p>
                <p class="tw-text-[100px] tw-text-[#001281] tw-text-center" x-text="name"></p>
            </div>
        </div>
        <div class="tw-w-full">
            <img src="https://picsum.photos/1920/1080" alt=""
                class="tw-w-full tw-h-full tw-object-cover tw-object-center">
        </div>
    </div>
    <div class="tw-bg-[#151F5B] tw-py-6">
        <marquee class="tw-text-[#EBFF0A] tw-text-5xl">
            {{ $running_text }}
        </marquee>
    </div>
</div>

@assets
    <script src='https://code.responsivevoice.org/responsivevoice.js'></script>
@endassets

@script
    <script>
        Alpine.data('queue', () => ({
            queue_number: @entangle('queue_number').live,
            name: @entangle('name').live,
            init() {
                setInterval(this.showTime, 1000);
                let queue = window.localStorage.getItem('queue')
                if (queue) {
                    $wire.getPatient(queue)
                }
                window.addEventListener('storage', () => {
                    let queue = window.localStorage.getItem('queue')
                    $wire.getPatient(queue)
                    if (queue > 0) {
                        responsiveVoice.speak(
                            `Nomor antrian ${queue} silakan ke ruang periksa`,
                            "Indonesian Female", {
                                pitch: 1,
                                rate: 1,
                                volume: 1
                            }
                        );
                    }
                })
            },
            showTime() {
                let time = new Date();
                let hour =
                    time.getHours();
                let min =
                    time.getMinutes();
                let sec =
                    time.getSeconds();

                hour =
                    hour < 10 ?
                    "0" + hour :
                    hour;
                min =
                    min < 10 ?
                    "0" + min :
                    min;
                sec =
                    sec < 10 ?
                    "0" + sec :
                    sec;

                let currentTime =
                    hour +
                    ":" +
                    min +
                    ":" +
                    sec;
                document.getElementById(
                        "time"
                    ).innerHTML =
                    currentTime;
            }
        }))
    </script>
@endscript
