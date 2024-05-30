<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage_kategori', function($user){
            return $user->hasAnyPermission([
                'kategori_show',
                'kategori_create',
                'kategori_update',
                'kategori_delete'
            ]);
        });
        Gate::define('manage_bahan', function($user){
            return $user->hasAnyPermission([
                'bahan_show',
                'bahan_create',
                'bahan_update',
                'bahan_delete'
            ]);
        });
        Gate::define('menage_pembelian', function($user){
            return $user->hasAnyPermission([
                'pembelian_show',
                'pembelian_create',
                'pembelian_update',
            ]);
        });
        Gate::define('menage_pengeluaran', function($user){
            return $user->hasAnyPermission([
                'pengeluaran_show',
                'pengeluaran_create',
                'pengeluaran_update',
            ]);
        });
        Gate::define('menage_stok', function($user){
            return $user->hasAnyPermission([
                'stok_show',
                'stok_update',
            ]);
        });
        Gate::define('menage_role', function($user){
            return $user->hasAnyPermission([
                'role_show',
                'role_create',
                'role_edit',
                'role_delete'
            ]);
        });
        Gate::define('menage_user', function($user){
            return $user->hasAnyPermission([
                'user_show',
                'user_create',
                'user_update',
                'user_delete'
            ]);
        });
        Gate::define('menage_laporan', function($user){
            return $user->hasAnyPermission([
                'laporan_show',
            ]);
        });
        Gate::define('menage_pengaturan', function($user){
            return $user->hasAnyPermission([
                'pengaturan_show',
            ]);
        });
    }
}
