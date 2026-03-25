@extends('layouts.app')

@section('title', 'Haber Detayı - Türkiye Haber Analizi')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Haber Detay Sayfası (Geliştirme Aşamasında)
            </h1>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-700">
                    Bu sayfa henüz geliştirme aşamasındadır. Haber ID: <strong>{{ $newsId }}</strong>
                </p>
            </div>

            <p class="text-gray-600 mb-6">
                Yakında bu sayfada haber detayları, farklı kaynaklardan gelen haberlerin karşılaştırması
                ve medya yanlılık analizi görebileceksiniz.
            </p>

            <a href="{{ url('/') }}"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Ana Sayfaya Dön
            </a>
        </div>
    </div>
@endsection