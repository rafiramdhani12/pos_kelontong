<?php

namespace App\Controllers;

use App\Models\AuditTrailModel;

class AuditTrail extends BaseController
{
    public function index()
    {
        // Validasi Owner
        if (session()->get('user_role') !== 'owner') {
            return redirect()->to('/dashboard')->with('error', 'Hanya Owner yang dapat mengakses Audit Trail.');
        }

        $auditModel = new AuditTrailModel();
        
        // Join ke users untuk melihat siapa yang melakukan rollback
        // Karena audit_trail menyimpan detail_transaksi_id, kita bisa join ke sana jika ingin info lebih detail
        // Namun saat ini detail_transaksi mungkin sudah dihapus jika rollback sudah selesai (tergantung timing)
        // Jadi kita tampilkan data mentah audit trail dulu
        $data = [
            'title'        => 'Audit Trail — AmbaToys',
            'page_heading' => 'Log Audit Rollback',
            'audits'       => $auditModel->select('audit_trail.*, users.nama as nama_user')
                                         ->join('users', 'users.id = audit_trail.user_id')
                                         ->orderBy('created_at', 'DESC')
                                         ->findAll(),
        ];

        return view('pages/audit_trail/index', $data);
    }
}
