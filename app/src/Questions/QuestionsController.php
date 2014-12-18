<?php

namespace Teso\Questions;

class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->questions = new \Teso\Questions\Question();
        $this->questions->setDI($this->di);
        $this->filter = new \Anax\Content\CTextFilter();
        $this->filter->setDI($this->di);
    }

    public function viewAllAction()
    {
        $output = null;

        if(isset($_POST['doAsk'])){
            $output = $this->addQuestion();
        }

        $sql = "SELECT * FROM vquestion ORDER BY posted DESC;";

        $all = $this->db->executeFetchAll($sql);

        $sql = "SELECT * FROM tags";

        $tags = $this->tagsAsOptions();


        
        $this->views->add('teso/questions', [
            'subTitle' => 'Latest',
            'questions' => $all,
            'tags' => $tags,
            'output' => $output,
            'user' => $this->di->session->get('user'),
        ]);
    }

    public function viewTagAction($tagId = null)
    {
        $output = null;

        if(isset($_POST['doAsk'])){
            $output = $this->addQuestion();
        }

        $sql = "SELECT vquestion.*,q2t.tagId FROM vquestion LEFT OUTER JOIN question2tag AS q2t ON q2t.questionId = vquestion.id WHERE tagId = ?";

        $all = $this->db->executeFetchAll($sql,array($tagId));

        $tags = $this->tagsAsOptions();

        $sql = "SELECT name FROM tags WHERE id=?;";
        $res = $this->db->executeFetchAll($sql,array($tagId));
        $tagName = $res[0]->name;

        $this->views->add('teso/questions', [
            'subTitle' => 'Tag: '.$tagName,
            'questions' => $all,
            'tags' => $tags,
            'output' => $output,
            'user' => $this->di->session->get('user'),
        ]);
    }

    public function idAction($id = null){
        $output = null;

        if(isset($_POST['doAnswer'])){
            $output = $this->addAnswer();
        }
		
		if(isset($_POST['doComment'])){
			$output = $this->addComment();
		}

        $this->theme->setTitle("View question");
        $sql = "SELECT * FROM vquestion WHERE id = ?;";
        $res = $this->db->executeFetchAll($sql,array($id));
        $question = $res[0];

        $sql = "SELECT * FROM vanswer WHERE questionId = ?;";
        $answers = $this->db->executeFetchAll($sql,array($question->id));

        $sql = "SELECT * FROM vcomment;";
        $comments = $this->db->executeFetchAll($sql);

        $this->views->add('teso/question', [
            'question' => $question,
            'title' => $question->title,
            'answers' => $answers,
            'comments' => $comments,
            'output' => $output,
            'user' => $this->di->session->get('user')
        ]);
    }

    private function addAnswer(){
        if(!empty($_POST['answerInput'])){
            $answerText = $this->filter->doFilter(strip_tags($_POST['answerInput']),'markdown');
            $now = date('y-m-d H:i:s');
            $sql = "INSERT INTO answer (text,posted,userId,questionId) VALUES (?,?,?,?);";
            $params = array($answerText,$now,$_POST['userId'],$_POST['questionId']);

            $this->db->execute($sql, $params);

            return "Your answer was successfully posted.";
        }

        return "Answer can't be empty!";

    }
	
	private function addComment(){
        if(!empty($_POST['commentText'])){
            $now = date('y-m-d H:i:s');
            $commentText = $this->filter->doFilter(strip_tags($_POST['commentText']),'markdown');

            if(isset($_POST['questionId'])){
                $sql = "INSERT INTO comment (text,posted,questionId,userId) VALUES (?,?,?,?);";
                $params = array($commentText,$now,$_POST['questionId'], $_POST['userId']);
            }elseif(isset($_POST['answerId'])){
                $sql = "INSERT INTO comment (text,posted,answerId,userId) VALUES (?,?,?,?);";
                $params = array($commentText,$now, $_POST['answerId'], $_POST['userId']);      
            }
            
            $this->db->execute($sql,$params);

            return "Your comment was successfully posted.";
        }

		return "Comment can't be ampty!";
		
	}

    private function addQuestion()
    {
        if(!empty($_POST['questionTitle']) && !empty($_POST['questionText']) && !empty($_POST['questionTags'])){
            $now = date('y-m-d H:i:s');
            $questionTitle = strip_tags($_POST['questionTitle']);
            $questionText = $this->filter->doFilter(strip_tags($_POST['questionText']),'markdown');

            $sql="INSERT INTO question (title,text,posted,userId) VALUES (?,?,?,?)";
            $params = array($questionTitle,$questionText,$now,$_POST['userId']);
            $this->db->execute($sql,$params);

            $qId = $this->db->lastInsertId();
            $selectedTags = $_POST['questionTags'];

            foreach($selectedTags as $selectedTag){
                $sql="INSERT INTO question2tag VALUES (?,?);";
                $params = array($qId,$selectedTag);
                $this->db->execute($sql,$params);
            }

            return "Your question was successfully posted.";          
        }

        return "Question must have title, text and at least one tag.";

    }

    private function tagsAsOptions(){
        $sql = "SELECT * FROM tags";

        $tags = $this->db->executeFetchAll($sql);

        $tagOptions = null;
        foreach ($tags as $tag) {
            $tagOptions .= "<option value='".$tag->id."'>".$tag->name."</option>";
        }

        return $tagOptions;
    }


}
