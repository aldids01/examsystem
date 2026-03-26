<div
    x-data="{
        time: {{ $time }},
        minutes: 0,
        seconds: 0,
        init() {
            this.minutes = Math.floor(this.time / 60)
            this.seconds = this.time % 60

            setInterval(() => {

                if(this.seconds === 0){
                    if(this.minutes === 0){
                        $wire.submitExam()
                        return
                    }

                    this.minutes--
                    this.seconds = 59
                }else{
                    this.seconds--
                }

            },1000)
        }
    }"
    class="flex items-center justify-between bg-danger-50 border border-danger-200 rounded-xl p-4 mb-6"
>
    <div class="font-bold text-danger-600 text-lg">
        Exam Timer
    </div>

    <div class="text-xl font-bold text-danger-700">
        <span x-text="String(minutes).padStart(2,'0')"></span> :
        <span x-text="String(seconds).padStart(2,'0')"></span>
    </div>
</div>
