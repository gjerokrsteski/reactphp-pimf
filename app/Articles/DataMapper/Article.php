<?php
namespace Articles\DataMapper;

use Pimf\DataMapper\Base;

class Article extends Base
{
    /**
     * @param $id
     *
     * @return null|\Articles\Model\Article
     */
    public function find($id)
    {
        $sth = $this->pdo->prepare(
            'SELECT * FROM blog WHERE id = :id'
        );

        $sth->bindValue(':id', $id);

        $sth->setFetchMode(
            \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
            '\Articles\Model\Article',
            ['title', 'content']
        );

        $sth->execute();

        // let pdo fetch the User instance for you.
        $article = $sth->fetch();

        if ($article === false) {
            return null;
        }

        // set the protected id of user via reflection.
        $article = $this->reflect($article, (int)$id);

        return $article;
    }

    /**
     * @return \Articles\Model\Article[]
     */
    public function getAll()
    {
        $sth = $this->pdo->prepare(
            'SELECT * FROM blog'
        );

        $sth->setFetchMode(
            \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
            '\Articles\Model\Article',
            array('title', 'content')
        );

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param \Articles\Model\Article $article
     *
     * @return int
     * @throws \RuntimeException
     */
    public function insert(\Articles\Model\Article $article)
    {
        $sth = $this->pdo->prepare(
            "INSERT INTO blog (title, content) VALUES (:title, :content)"
        );

        $sth->bindValue(':title', $article->getTitle());
        $sth->bindValue(':content', $article->getContent());
        $sth->execute();

        $id = (int)$this->pdo->lastInsertId();

        return $id;
    }

    /**
     * @param \Articles\Model\Article $article
     *
     * @return bool
     */
    public function update(\Articles\Model\Article $article)
    {
        $sth = $this->pdo->prepare(
            "UPDATE blog SET title = :title, content = :content WHERE id = :id"
        );

        $sth->bindValue(':title', $article->getTitle());
        $sth->bindValue(':content', $article->getContent());
        $sth->bindValue(':id', $article->getId(), \PDO::PARAM_INT);

        $sth->execute();

        if ($sth->rowCount() == 1) {
            return true;
        }

        return false;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $sth = $this->pdo->prepare(
            "DELETE FROM blog WHERE id = :id"
        );

        $sth->bindValue(':id', $id, \PDO::PARAM_INT);
        $sth->execute();

        if ($sth->rowCount() == 0) {
            return false;
        }

        return true;
    }
}
