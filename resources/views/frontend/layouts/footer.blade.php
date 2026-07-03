<footer style="background-color: #0a0a0a; color: #d4d4d4;">
    {{-- Main Content --}}
    <div style="max-width: 80rem; margin: 0 auto; padding: 4rem 1rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2.5rem;">
            {{-- About --}}
            <div>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: white; font-size: 1rem;">School Portal</div>
                        <div style="font-size: 0.75rem; color: #737373;">Excellence in Education</div>
                    </div>
                </div>
                <p style="font-size: 0.875rem; color: #a3a3a3; line-height: 1.625; margin: 0;">
                    Providing quality education and fostering excellence in students. Our commitment is to create a nurturing environment where every student can thrive.
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 style="font-weight: 700; color: white; margin-bottom: 1.25rem; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Quick Links</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li><a href="{{ route('home') }}" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">Home</a></li>
                    <li><a href="{{ route('frontend.posts.index') }}" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">News & Articles</a></li>
                    <li><a href="{{ route('frontend.about') }}" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">About Us</a></li>
                    <li><a href="{{ route('frontend.gallery') }}" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">Gallery</a></li>
                    <li><a href="{{ route('frontend.contact') }}" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">Contact Us</a></li>
                </ul>
            </div>

            {{-- Resources --}}
            <div>
                <h4 style="font-weight: 700; color: white; margin-bottom: 1.25rem; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Resources</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li><a href="#" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">Announcements</a></li>
                    <li><a href="#" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">Agenda</a></li>
                    <li><a href="#" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">Achievements</a></li>
                    <li><a href="#" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">Documents</a></li>
                    <li><a href="#" style="color: #a3a3a3; text-decoration: none; font-size: 0.875rem;">Videos</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 style="font-weight: 700; color: white; margin-bottom: 1.25rem; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Get in Touch</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
                    <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #a3a3a3;">
                        <svg style="width: 1rem; height: 1rem; color: #737373; flex-shrink: 0; margin-top: 0.125rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>123 Education Street, City, Country 12345</span>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #a3a3a3;">
                        <svg style="width: 1rem; height: 1rem; color: #737373; flex-shrink: 0; margin-top: 0.125rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>info@school.com</span>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #a3a3a3;">
                        <svg style="width: 1rem; height: 1rem; color: #737373; flex-shrink: 0; margin-top: 0.125rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>+123 456 7890</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div style="border-top: 1px solid #262626;">
        <div style="max-width: 80rem; margin: 0 auto; padding: 1.5rem 1rem; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;">
            <div style="font-size: 0.75rem; color: #737373;">
                © {{ date('Y') }} School Portal. All rights reserved.
            </div>
            <div style="display: flex; align-items: center; gap: 1.5rem; font-size: 0.75rem;">
                <a href="#" style="color: #737373; text-decoration: none;">Privacy Policy</a>
                <a href="#" style="color: #737373; text-decoration: none;">Terms of Service</a>
                <a href="#" style="color: #737373; text-decoration: none;">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
<script>
    // Toggle dark mode
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
</script>
