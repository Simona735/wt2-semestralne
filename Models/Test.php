<?php


class Test
{
    private int $ID;
    private string $title;
    private int $test_code;
    private string $duration;
    private int $teacher_ID;
    private bool $activation;

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @param int $ID
     */
    public function setID(int $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getTestCode(): int
    {
        return $this->test_code;
    }

    /**
     * @param int $test_code
     */
    public function setTestCode(int $test_code): void
    {
        $this->test_code = $test_code;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     */
    public function setDuration(string $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getTeacherID(): int
    {
        return $this->teacher_ID;
    }

    /**
     * @param int $teacher_ID
     */
    public function setTeacherID(int $teacher_ID): void
    {
        $this->teacher_ID = $teacher_ID;
    }

    /**
     * @return bool
     */
    public function isActivation(): bool
    {
        return $this->activation;
    }

    /**
     * @param bool $activation
     */
    public function setActivation(bool $activation): void
    {
        $this->activation = $activation;
    }


}