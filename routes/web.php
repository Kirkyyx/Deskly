    <?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\TicketController;
    use App\Http\Controllers\CommentController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\ArticleController;
    use App\Http\Controllers\AttachmentController;
    use App\Http\Controllers\AuditLogController;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\StaffTicketController;
    use App\Http\Controllers\UserDashboardController;
    use App\Http\Controllers\UserTicketController;
    use Illuminate\Support\Facades\Route;

    // =======================
    // Public routes
    // =======================
    Route::get('/', fn() => view('welcome'))->name('home');

    // =======================
    // Authenticated routes
    // =======================
    Route::middleware('auth')->group(function () {

        // ── Dashboards ──
        Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
            ->middleware('role:user')
            ->name('user.dashboard');

        Route::get('/staff/dashboard', fn() => view('staff.dashboard'))
            ->middleware('role:staff')
            ->name('staff.dashboard');

        Route::get('/admin/dashboard', [AdminController::class, 'index'])
            ->middleware('role:admin')
            ->name('admin.dashboard');

        // ── Profile (all roles) ──
        Route::prefix('profile')->group(function () {
            Route::get('/',    [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/',  [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        // =======================
        // Admin-only routes
        // =======================
// ✅ Fixed
            Route::middleware('role:admin')->group(function () {
                Route::resource('users',      UserController::class);
                Route::resource('categories', CategoryController::class);
            });

            Route::middleware('role:admin')
                ->prefix('admin')
                ->name('admin.')
                ->group(function () {
                    Route::resource('articles', ArticleController::class);
                    Route::patch('articles/{article}/toggle-status', [ArticleController::class, 'toggleStatus'])
                        ->name('articles.toggle-status');
                });

        // =======================
        // Admin + Staff routes
        // =======================
        Route::middleware('role:admin,staff')->group(function () {
            Route::resource('audit-logs',  AuditLogController::class);
            Route::resource('attachments', AttachmentController::class);
        });

        // =======================
        // Admin + Staff + User (shared ticket resource)
        // =======================
        Route::middleware('role:admin,staff,user')->group(function () {
            Route::resource('tickets',  TicketController::class);
            Route::resource('comments', CommentController::class)->only(['store', 'destroy']);
        });

        // =======================
        // Staff-specific routes
        // =======================
        Route::middleware('role:staff')
            ->prefix('staff')
            ->name('staff.')
            ->group(function () {
                Route::get('/tickets',                           [StaffTicketController::class, 'index'])->name('tickets.index');
                Route::get('/tickets/{ticket}',                  [StaffTicketController::class, 'show'])->name('tickets.show');
                Route::post('/tickets/{ticket}/reply',            [StaffTicketController::class, 'reply'])->name('tickets.reply');
                Route::patch('/tickets/{ticket}/update-status',   [StaffTicketController::class, 'updateStatus'])->name('tickets.update-status');
            });

        // =======================
        // User-specific routes
        // =======================
        Route::middleware('role:user')
            ->prefix('user')
            ->name('user.')
            ->group(function () {
                Route::get('/tickets',                  [UserTicketController::class, 'index'])->name('tickets.index');
                Route::get('/tickets/create',           [UserTicketController::class, 'create'])->name('tickets.create');
                Route::post('/tickets',                 [UserTicketController::class, 'store'])->name('tickets.store');
                Route::get('/tickets/{ticket}',         [UserTicketController::class, 'show'])->name('tickets.show');
                Route::post('/tickets/{ticket}/reply',  [UserTicketController::class, 'reply'])->name('tickets.reply');
                Route::patch('/tickets/{ticket}/close', [UserTicketController::class, 'close'])->name('tickets.close');
            });
    });

    // =======================
    // Auth routes (login, register, etc.)
    // =======================
    require __DIR__ . '/auth.php';