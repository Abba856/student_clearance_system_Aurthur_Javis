<style>
/* Modern footer styles */
.main-footer {
  background: linear-gradient(135deg, #4361ee, #3a0ca3);
  color: white;
  padding: 25px 0;
  margin-top: auto;
  border-top: 1px solid rgba(255,255,255,0.1);
  box-shadow: 0 -5px 15px rgba(0,0,0,0.05);
  z-index: 999;
  position: relative;
}

.footer-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.footer-text {
  color: rgba(255, 255, 255, 0.85);
  margin: 0;
  font-size: 0.9rem;
  line-height: 1.6;
}

.footer-text a {
  color: #4cc9f0;
  text-decoration: none;
  transition: all 0.3s ease;
}

.footer-text a:hover {
  color: #4895ef;
  text-decoration: underline;
}

.footer-divider {
  width: 100%;
  height: 1px;
  background: rgba(255, 255, 255, 0.1);
  margin: 15px 0;
}

.footer-developed-by {
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.8rem;
  margin-top: 8px;
}

.heart-icon {
  color: #ff6b6b;
  margin: 0 5px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .footer-text {
    font-size: 0.8rem;
  }

  .footer-developed-by {
    font-size: 0.75rem;
  }
}
</style>

<footer class="main-footer">
  <div class="container-fluid">
    <div class="footer-content">
      <p class="footer-text">
        &copy; <?php echo date("Y"); ?> Arthur Javis University, Calabar. 
        All Rights Reserved.
      </p>
      <div class="footer-divider"></div>
      <p class="footer-text">
        Student Clearance System | 
        Developed with <i class="heart-icon fas fa-heart"></i> by Student Development Team
      </p>
      <p class="footer-developed-by">
        EKE, EMMANUEL EFA-EVAL | 18/132010
      </p>
    </div>
  </div>
</footer>