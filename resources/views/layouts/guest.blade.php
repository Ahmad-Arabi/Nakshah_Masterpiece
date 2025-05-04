<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Nakshah') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-color: #4B3F72;
                --accent-color: #FF6B6B;
                --mint-green: #C8E6C9;
                --warm-beige: #F5F0E1;
                --charcoal-gray: #333333;
            }
            
            body {
                font-family: 'Poppins', sans-serif;
                background-color: var(--warm-beige);
                color: var(--charcoal-gray);
                margin: 0;
                padding: 0;
            }
            
            .auth-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 1rem;
            }
            
            .brand-logo {
                margin-bottom: 1.25rem;
            }
            
            .brand-name {
                font-size: 2.25rem;
                font-weight: 700;
                color: var(--primary-color);
                text-decoration: none;
                letter-spacing: 1px;
            }
            
            .auth-card {
                width: 100%;
                max-width: 400px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                padding: 1.5rem;
                position: relative;
                overflow: hidden;
            }
            
            .auth-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 5px;
                background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            }
            
            .auth-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--primary-color);
                margin-bottom: 1.25rem;
                text-align: center;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
            
            .form-label {
                display: block;
                font-weight: 500;
                margin-bottom: 0.4rem;
                color: var(--charcoal-gray);
            }
            
            .form-input {
                width: 100%;
                padding: 0.65rem 1rem;
                border: 1px solid #e2e8f0;
                border-radius: 5px;
                font-size: 0.95rem;
                transition: all 0.3s ease;
                box-sizing: border-box;
            }
            
            .form-input:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(75, 63, 114, 0.1);
            }
            
            .form-error {
                color: var(--accent-color);
                font-size: 0.85rem;
                margin-top: 0.25rem;
            }
            
            .primary-button {
                background-color: var(--primary-color);
                color: white;
                font-weight: 600;
                padding: 0.65rem 1.25rem;
                border-radius: 5px;
                border: none;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .primary-button:hover {
                background-color: #3c335d;
                transform: translateY(-2px);
            }
            
            .auth-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 1.25rem;
            }
            
            .auth-link {
                color: var(--primary-color);
                font-weight: 500;
                text-decoration: none;
                transition: all 0.3s ease;
                font-size: 0.9rem;
            }
            
            .auth-link:hover {
                color: var(--accent-color);
                text-decoration: underline;
            }
            
            .checkbox-container {
                display: flex;
                align-items: center;
            }
            
            .checkbox-container input[type="checkbox"] {
                margin-right: 0.5rem;
                accent-color: var(--primary-color);
            }
            
            /* Responsive Styles */
            @media (max-width: 767px) {
                .auth-card {
                    margin: 0 auto;
                    padding: 1.25rem;
                    border-radius: 8px;
                    max-width: 90%;
                }
                
                .landscape-container {
                    width: 100%;
                    display: block;
                }
                
                .landscape-image {
                    display: none;
                }
                
                .landscape-form {
                    max-width: 90%;
                    margin: 0 auto;
                    padding: 1.25rem;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                    border-radius: 10px;
                }
                
                .landscape-form::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 5px;
                    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
                }
                
                .brand-name {
                    font-size: 1.8rem;
                }
                
                .auth-title {
                    font-size: 1.3rem;
                    margin-bottom: 1rem;
                }
                
                .form-group {
                    margin-bottom: 0.8rem;
                }
                
                .form-input {
                    padding: 0.6rem 0.8rem;
                }
                
                .auth-container {
                    padding: 1rem 0;
                    align-items: center;
                }
            }
            
            @media (min-width: 768px) {
                .auth-container {
                    padding: 2rem;
                }
                
                .landscape-container {
                    display: flex;
                    max-width: 1000px;
                    margin: 0 auto;
                    background-color: white;
                    border-radius: 10px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                    overflow: hidden;
                }
                
                .landscape-image {
                    flex: 1;
                    background: linear-gradient(to bottom right, var(--primary-color), var(--accent-color));
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 2rem;
                }
                
                .landscape-image-content {
                    text-align: center;
                    color: white;
                }
                
                .landscape-image-content h2 {
                    font-size: 2rem;
                    margin-bottom: 1rem;
                }
                
                .landscape-image-content p {
                    font-size: 1.1rem;
                    margin-bottom: 0;
                    opacity: 0.9;
                }
                
                .landscape-form {
                    flex: 1.2;
                    padding: 2rem;
                    max-width: none;
                    box-shadow: none;
                    border-radius: 0;
                }
                
                .landscape-form::before {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            @if(Route::currentRouteName() == 'register' && request()->is('register'))
                <div class="landscape-container">
                    <div class="landscape-image">
                        <div class="landscape-image-content">
                            <h2>Welcome to Nakshah</h2>
                            <p>Made by you, for you!</p>
                        </div>
                    </div>
                    <div class="auth-card landscape-form">
                        {{ $slot }}
                    </div>
                </div>
            @else
                <div class="brand-logo">
                    <a href="/" class="brand-name">نقشة Nakshah</a>
                </div>
                
                <div class="auth-card">
                    {{ $slot }}
                </div>
            @endif
        </div>
    </body>
</html>
