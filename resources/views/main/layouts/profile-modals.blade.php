<!-- Update Password Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Slaptažodžio keitimas</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.updatePassword') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Dabartinis slaptažodis</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Naujas slaptažodis</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="password-strength mt-2">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <small class="strength-text" id="strengthText">Įveskite slaptažodį</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Patvirtinti naują slaptažodį</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        <div class="password-match mt-2">
                            <small class="match-text" id="matchText" style="display: none;"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Atšaukti</button>
                        <button type="submit" class="btn btn-secondary">Atnaujinti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Image Modal -->
<div class="modal fade" id="updateImageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profilio nuotraukos įkėlimas</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.updateImage') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Pasirinkite nuotrauką</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Atšaukti</button>
                        <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Image Modal -->
<div class="modal fade" id="deleteImageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profilio nuotraukos pašalinimas</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ar tikrai norite pašalinti profilio nuotrauką?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('profile.deleteImage') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Atšaukti</button>
                    <button type="submit" class="btn btn-secondary">Patvirtinti</button>
                </form>
            </div>
        </div>
    </div>
</div>
