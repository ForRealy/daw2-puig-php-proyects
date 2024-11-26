// src/Controller/FormController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;

class FormController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_form")
     */
    public function contact(Request $request, FormFactoryInterface $formFactory): Response
    {
        // Create a simple form using Symfony's form builder
        $form = $formFactory->createBuilder()
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('message', TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Send Message',
            ])
            ->getForm();

        // Handle the request and check if the form is submitted and valid
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Process the data (e.g., save it to the database, send email, etc.)

            // Redirect after success
            return $this->redirectToRoute('form_success');
        }

        // Render the form in Twig
        return $this->render('form/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
