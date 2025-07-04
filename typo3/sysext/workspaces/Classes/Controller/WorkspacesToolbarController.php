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

namespace TYPO3\CMS\Workspaces\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Module\ModuleProvider;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Workspaces\Service\WorkspaceService;

/**
 * Implements the AJAX functionality for the various asynchronous calls.
 *
 * @internal This is a specific Backend Controller implementation and is not considered part of the Public TYPO3 API.
 */
#[AsController]
final readonly class WorkspacesToolbarController
{
    public function __construct(
        private WorkspaceService $workspaceService,
        private ModuleProvider $moduleProvider,
    ) {}

    /**
     * Sets the TYPO3 Backend context to a certain workspace,
     * called by the Backend toolbar menu
     */
    public function switchWorkspaceAction(ServerRequestInterface $request): ResponseInterface
    {
        $page = [];
        $parsedBody = $request->getParsedBody();
        $queryParams = $request->getQueryParams();
        $workspaceId = (int)($parsedBody['workspaceId'] ?? $queryParams['workspaceId']);
        $pageId = (int)($parsedBody['pageId'] ?? $queryParams['pageId'] ?? 0);
        $finalPageUid = 0;
        $originalPageId = $pageId;
        $backendUser = $this->getBackendUser();
        $backendUser->setWorkspace($workspaceId);
        while ($pageId) {
            $page = BackendUtility::getRecordWSOL('pages', $pageId, '*', ' AND pages.t3ver_wsid IN (0, ' . $workspaceId . ')');
            if ($page) {
                if ($backendUser->doesUserHaveAccess($page, Permission::PAGE_SHOW)) {
                    break;
                }
            } else {
                $page = BackendUtility::getRecord('pages', $pageId);
            }
            $pageId = $page['pid'];
        }
        if (isset($page['uid'])) {
            $finalPageUid = (int)$page['uid'];
        }
        $ajaxResponse = [
            'title' => $this->workspaceService->getWorkspaceTitle($workspaceId),
            'workspaceId' => $workspaceId,
            'pageId' => ($finalPageUid && $originalPageId == $finalPageUid) ? null : $finalPageUid,
            'pageModule' => $this->moduleProvider->accessGranted('web_layout', $backendUser) ? 'web_layout' : '',
        ];
        return new JsonResponse($ajaxResponse);
    }

    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
