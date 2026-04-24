<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Courses\Widgets\ExamTimeTable;
use App\Filament\Student\Pages\Auth\StudentLogin;
use App\Filament\Student\Pages\Auth\StudentProfile;
use App\Filament\Student\Resources\Exams\Widgets\StudentExamTimeTable;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Filament\Enums\UserMenuPosition;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class StudentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('student')
            ->path('exam')
            ->authGuard('student')
            ->login(StudentLogin::class)
            ->profile(StudentProfile::class, isSimple: false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarWidth('12rem')
            ->userMenu(position: UserMenuPosition::Sidebar)
            ->spa(hasPrefetching: true)
            ->maxContentWidth(Width::Full)
            ->discoverResources(in: app_path('Filament/Student/Resources'), for: 'App\Filament\Student\Resources')
            ->discoverPages(in: app_path('Filament/Student/Pages'), for: 'App\Filament\Student\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Student/Widgets'), for: 'App\Filament\Student\Widgets')
            ->widgets([
              StudentExamTimeTable::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                AuthDesignerPlugin::make()
                    ->themeToggle()
                    ->login()
                    ->registration()
                    ->passwordReset()
                    ->emailVerification()
                    ->defaults(fn (AuthPageConfig $config) => $config
                        ->media(asset('school.jpg'))
                        ->mediaPosition(MediaPosition::Left)
                        ->mediaSize('60%')
                    ),
            ])
            ->viteTheme('resources/css/filament/student/theme.css');
    }
}
