<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\Backend\Controller\Wizard;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Fluid\View\BackendTemplateView;

/**
 * Wizard for rendering image manipulation view
 * @internal This class is a specific Backend controller implementation and is not considered part of the Public TYPO3 API.
 */
class ImageManipulationController
{
    private BackendTemplateView $templateView;

    public function __construct()
    {
        $templateView = GeneralUtility::makeInstance(BackendTemplateView::class);
        $templateView->setTemplateRootPaths(['EXT:backend/Resources/Private/Templates/']);
        $this->templateView = $templateView;
    }

    /**
     * Returns the HTML for the wizard inside the modal
     */
    public function getWizardContent(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->isSignatureValid($request)) {
            $parsedBody = json_decode($request->getParsedBody()['arguments'], true);
            $fileUid = $parsedBody['image'];
            $image = null;
            if (MathUtility::canBeInterpretedAsInteger($fileUid)) {
                try {
                    $image = GeneralUtility::makeInstance(ResourceFactory::class)->getFileObject($fileUid);
                } catch (FileDoesNotExistException $e) {
                }
            }
            $this->templateView->assignMultiple([
                'image' => $image,
                'cropVariants' => $parsedBody['cropVariants'],
            ]);
            return new HtmlResponse($this->templateView->render('Form/ImageManipulationWizard'));
        }
        return new HtmlResponse('', 403);
    }

    /**
     * Check if hmac signature is correct
     *
     * @param ServerRequestInterface $request the request with the POST parameters
     * @return bool
     */
    protected function isSignatureValid(ServerRequestInterface $request): bool
    {
        $token = GeneralUtility::hmac($request->getParsedBody()['arguments'], 'ajax_wizard_image_manipulation');
        return hash_equals($token, $request->getParsedBody()['signature']);
    }
}
