<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\Exceptions\PageNotFoundException;

class TemplatesModel extends Model
{
    protected $table            = 'templates';
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

    public function getQuantTemplates(): int
    {
        $queryString = "SELECT COUNT(id) AS total_registros FROM templates";
        return $this->query($queryString)->getResultArray()[0]['total_registros'];
    }

    public function getTemplates(): array
    {
        $queryString = "SELECT id, nome, assunto, mensagem FROM templates";
        return $this->query($queryString)->getResultArray();
        // return $this->findAll(); // estou fazendo select manual para organizar a ordem das colunas
    }

    public function getTemplate($id): array
    {
        $template = $this->find($id);

        if ($template === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $template;
    }

    public function removeTemplate($id): bool
    {
        // confirma que existe
        $template = $this->find($id);

        if ($template === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->delete($id);
    }

    public function salvaTemplate($data): bool
    {
        // save() = insert() or update()
        return $this->save($data);
    }


}
