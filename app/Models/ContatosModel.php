<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\Exceptions\PageNotFoundException;

class ContatosModel extends Model
{
    protected $table            = 'contatos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false; //??? porque eu gostaria de proteger campos???
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getQuantContatos(): int
    {
        $queryString = "SELECT COUNT(id) AS total_registros FROM contatos";
        return $this->query($queryString)->getResultArray()[0]['total_registros'];
    }

    public function getContatos(): array
    {
        return $this->findAll();
    }

    public function getContato($id)
    {
        $contato = $this->find($id);

        if ($contato === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $contato;
    }

    public function removeContato($id): bool
    {
        // confirma que existe
        $contato = $this->find($id);

        if ($contato === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        
        return $this->delete($id);
    }

    public function salvaContato($data): bool
    {
        // save() = insert() or update()
        return $this->save($data);
    }


}
