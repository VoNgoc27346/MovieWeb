
<?php include('./views/layouts/header.php'); ?>

    <main class="flex max-w-[1200px] mx-auto pt-6 pb-12 gap-6">
      <!-- MAIN LEFT: Video player + Info + Cast + Comments -->
      <section class="flex-1 min-w-0">
        <!-- Player area -->
        <div class="relative bg-black rounded-lg overflow-hidden aspect-video flex items-center justify-center">
          <img src="https://ugc.same-assets.com/BF78sGwpebNcn8Iv49PxI25YFftGou9y.jpeg" alt="Mock Video" class="w-full h-full object-contain opacity-80" />
          <button class="absolute bottom-4 left-4 bg-white/20 hover:bg-white/30 flex items-center px-3 py-1 rounded-full text-white text-sm"><svg class="w-5 h-5 mr-1" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4l15 8-15 8z"/></svg> Play</button>
        </div>
        <div class="flex flex-col mt-6 gap-2">
          <h1 class="text-2xl font-semibold">Phoenix's Gambit: Love or Crown</h1>
          <div class="text-[#dbddcb] text-xs flex items-center gap-2">
            <span class="bg-[#27bd52]/20 rounded px-2 py-0.5 text-[#27bd52] font-bold">TOP4</span>
            <span class="bg-[#3c3e44] rounded px-2 py-0.5">New Dramas</span>
            <span class="bg-[#ffc345]/20 rounded px-2 py-0.5 text-[#ffc345] font-medium">VIP</span>
            <span class="text-[#686b70]">TV-PG</span>
            <span class="ml-2">2025</span>
            <span class="ml-2">24 Episodes</span>
          </div>
          <p class="text-[#dbddcb] text-sm mt-1">Description: The scheming concubine-born daughter of the Minister’s household, Bai Xiyue, caused the death of her legitimate sister Bai Xiyao, and seduced Duke Yun Yichen, eventually becoming empress. However, she was poisoned and died suddenly during the coronation ceremony...</p>
        </div>
        <!-- Cast Section -->
        <div class="mt-6">
          <h2 class="font-semibold text-lg mb-2 text-[#dbddcb]">Cast</h2>
          <div class="flex gap-5 flex-wrap">
            <!-- Cast Avatars: 5 mẫu -->
            <div class="flex flex-col items-center w-16">
              <img src="https://ext.same-assets.com/3427629531/2457699613.png" class="h-16 w-16 rounded-full mb-1 bg-[#23252e] object-cover" alt="Jiu Mu Hogan" />
              <span class="text-xs text-center">Jiu Mu Hogan</span>
              <span class="text-[10px] text-[#686b70]">Director</span>
            </div>
            <div class="flex flex-col items-center w-16">
              <img src="https://ext.same-assets.com/3427629531/2457699613.png" class="h-16 w-16 rounded-full mb-1 bg-[#23252e] object-cover" alt="Gao Si Wen" />
              <span class="text-xs text-center">Gao Si Wen</span>
              <span class="text-[10px] text-[#686b70]">Cast</span>
            </div>
            <div class="flex flex-col items-center w-16">
              <img src="https://ext.same-assets.com/3427629531/2457699613.png" class="h-16 w-16 rounded-full mb-1 bg-[#23252e] object-cover" alt="Lu Dong Xu" />
              <span class="text-xs text-center">Lu Dong Xu</span>
              <span class="text-[10px] text-[#686b70]">Cast</span>
            </div>
            <div class="flex flex-col items-center w-16">
              <img src="https://ext.same-assets.com/3427629531/2457699613.png" class="h-16 w-16 rounded-full mb-1 bg-[#23252e] object-cover" alt="Wang Yani" />
              <span class="text-xs text-center">Wang Yani</span>
              <span class="text-[10px] text-[#686b70]">Cast</span>
            </div>
            <div class="flex flex-col items-center w-16">
              <img src="https://ext.same-assets.com/3427629531/2457699613.png" class="h-16 w-16 rounded-full mb-1 bg-[#23252e] object-cover" alt="Cui Xu Yu" />
              <span class="text-xs text-center">Cui Xu Yu</span>
              <span class="text-[10px] text-[#686b70]">Cast</span>
            </div>
          </div>
        </div>
        <!-- Comments Section -->
        <section class="mt-8">
          <h3 class="font-semibold mb-2 text-[#dbddcb]">10 Comments</h3>
          <div class="rounded bg-[#23252e] px-5 py-4 mb-3 flex flex-col gap-2">
            <input disabled value="Post a comment" class="w-full rounded bg-[#2e303a] px-4 py-2 text-[#686b70] focus:outline-none" />
            <button disabled class="mt-2 w-max px-4 py-1 bg-[#27bd52] text-white rounded hover:bg-[#15a642]">Login</button>
          </div>
          <div class="flex flex-col gap-6">
            <div class="flex gap-3 items-start">
              <img src="https://ext.same-assets.com/3427629531/2457699613.png" class="w-9 h-9 rounded-full mt-1" alt="Avatar" />
              <div>
                <span class="font-semibold text-sm">Halima Kaid</span>
                <span class="ml-2 text-xs text-[#686b70]">3 hour(s)</span>
                <div class="mt-1 text-sm">😊😊😊</div>
                <div class="flex gap-3 mt-1">
                  <button class="text-xs text-[#647a99] hover:text-[#27bd52]">Like</button>
                  <button class="text-xs text-[#647a99] hover:text-[#27bd52]">Reply</button>
                </div>
              </div>
            </div>
            <!-- Thêm comments mẫu nếu muốn -->
          </div>
        </section>
      </section>

      <!-- SIDEBAR bên phải -->
      <aside class="w-[320px] shrink-0 space-y-6">
        <section class="bg-[#23252e] rounded-lg p-4">
          <div class="text-[#dbddcb] font-semibold text-lg mb-2">Episodes 1-24</div>
          <div class="grid grid-cols-5 gap-2 text-center text-xs">
            <button class="rounded bg-[#27bd52] text-white py-1 font-medium">1</button>
            <button class="rounded bg-[#23252e] border border-[#2e303a] py-1 text-[#dbddcb]">2</button>
            <button class="rounded bg-[#23252e] border border-[#2e303a] py-1 text-[#dbddcb]">3</button>
            <button class="rounded bg-[#23252e] border border-[#2e303a] py-1 text-[#dbddcb]">4</button>
            <button class="rounded bg-[#23252e] border border-[#2e303a] py-1 text-[#dbddcb]">5</button>
            <!-- Thêm số tập khác -->
          </div>
          <div class="mt-4 flex justify-between">
            <span class="text-xs text-[#686b70]">VIP: 2 new episodes daily</span>
            <span class="text-xs text-[#ffc345]">Unlock more</span>
          </div>
        </section>
        <section class="rounded-lg bg-[#bd663b]/10 p-4">
          <div class="font-medium mb-2">15th Anniversary Sale! Up to 40% OFF >> </div>
          <button class="px-4 py-2 bg-[#ffc345] rounded font-semibold text-black/90">Learn More</button>
        </section>
        <section>
          <div class="font-semibold mb-2 text-[#dbddcb]">Top 10 Drama</div>
          <ol class="list-decimal list-inside text-[#dbddcb] text-sm space-y-1">
            <li>Phoenix's Gambit: Love or Crown</li>
            <li>Destiny and Saving</li>
            <li>Sweet Tooth, Good Dentist</li>
            <li>3A. Moment But Forever</li>
            <li>The Best Thing</li>
            <!-- ... -->
          </ol>
          <a href="#" class="block mt-3 px-4 py-2 bg-[#ffc345] text-black text-center font-semibold rounded">New VIP $1.99! JOIN NOW</a>
        </section>
      </aside>
    </main>

    <!-- COOKIE BANNER -->
    <div class="fixed z-50 left-1/2 -translate-x-1/2 bottom-10 w-[520px] rounded-xl bg-[#e4f3e8] text-[#13141a] shadow-lg flex items-center px-8 py-6 gap-6">
      <div class="flex-1 text-sm">Cookies are used to make our website work well, optimize user experience, deliver personalized content and ads, and perform website traffic analytics, etc. By clicking the button below, you agree to 'Accept All Cookies'. Alternatively, you can set different types of Cookies under "Set Cookies".</div>
      <div class="flex flex-col gap-2">
        <button class="px-6 py-1.5 bg-[#27bd52] rounded text-white font-bold">Accept All Cookies</button>
        <button class="px-6 py-1 bg-[#e9e9e9] border border-[#27bd52] rounded text-[#27bd52] font-bold">Set Cookies</button>
      </div>
    </div>

<?php include('./views/layouts/footer.php'); ?>
